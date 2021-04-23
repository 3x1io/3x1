<?php

namespace Brackets\AdminTranslations\Http\Responses;

use Brackets\AdminTranslations\Translation;
use Brackets\Translatable\Facades\Translatable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TranslationsAdminListingResponse implements Responsable
{
    /**
     * @var LengthAwarePaginator
     */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param $request
     * @return array|Factory|Response|View|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $locales = Translatable::getLocales();

        $this->data->getCollection()->map(function ($translation) use ($locales) {
            $locales->each(function ($locale) use ($translation) {
                /** @var Translation $translation */
                $translation->setTranslation($locale, $this->getCurrentTransForTranslation($translation, $locale));
            });

            return $translation;
        });

        if ($request->ajax()) {
            return ['data' => $this->data, 'locales' => $locales];
        }

        return view('brackets/admin-translations::admin.translation.index', [
            'data' => $this->data,
            'locales' => $locales,
            'groups' => $this->getUsedGroups(),
        ]);
    }

    /**
     * @param Translation $translation
     * @param $locale
     * @return array|Translator|string|null
     */
    private function getCurrentTransForTranslation(Translation $translation, $locale)
    {
        if ($translation->group === '*') {
            return __($translation->key, [], $locale);
        }

        if ($translation->namespace === '*') {
            return trans($translation->group . '.' . $translation->key, [], $locale);
        }

        return trans($translation->namespace . '::' . $translation->group . '.' . $translation->key, [], $locale);
    }

    /**
     * @return Collection
     */
    private function getUsedGroups(): Collection
    {
        return DB::table('translations')
            ->whereNull('deleted_at')
            ->groupBy('group')
            ->pluck('group');
    }
}
