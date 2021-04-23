<?php

namespace Brackets\AdminTranslations\Exports;

use Brackets\AdminTranslations\Translation;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TranslationsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @var Collection
     */
    private $exportLanguages;

    public function __construct($request)
    {
        $this->exportLanguages = collect($request->exportLanguages);
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return Translation::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'Namespace',
            'Group',
            'Default',
            'Created at',
        ];

        $this->exportLanguages->each(static function ($language) use (&$headings) {
            $headings[] = mb_strtoupper($language);
        });

        return $headings;
    }

    /**
     * @param Translation $translation
     * @return array
     */
    public function map($translation): array
    {
        $map = [
            $translation->namespace,
            $translation->group,
            $translation->key,
            $translation->created_at,
        ];

        $this->exportLanguages->each(function ($language) use (&$map, $translation) {
            array_push($map, $this->getCurrentTransForTranslationLanguage($translation, $language));
        });

        return $map;
    }

    /**
     * @param Translation $translation
     * @param string $language
     * @return array|Translator|string|null
     */
    private function getCurrentTransForTranslationLanguage(Translation $translation, string $language)
    {
        if ($translation->group === '*') {
            return __($translation->key, [], $language);
        } elseif ($translation->namespace === '*') {
            return trans($translation->group . '.' . $translation->key, [], $language);
        } else {
            return trans(stripslashes($translation->namespace) . '::' . $translation->group . '.' . $translation->key,
                [], $language);
        }
    }
}
