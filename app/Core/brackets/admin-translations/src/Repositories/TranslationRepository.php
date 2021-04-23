<?php

namespace Brackets\AdminTranslations\Repositories;

use Brackets\AdminTranslations\Translation;

class TranslationRepository
{
    /**
     * @param $namespace
     * @param $group
     * @param $key
     * @param $language
     * @param $text
     */
    public function createOrUpdate($namespace, $group, $key, $language, $text): void
    {
        /** @var Translation $translation */
        $translation = Translation::withTrashed()
            ->where('namespace', $namespace)
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        $defaultLocale = config('app.locale');

        if ($translation) {
            if (!$this->isCurrentTransForTranslationArray($translation, $defaultLocale)) {
                $translation->restore();
            }
        } else {
            $translation = Translation::make([
                'namespace' => $namespace,
                'group' => $group,
                'key' => $key,
                'text' => [$language => $text],
            ]);

            if (!$this->isCurrentTransForTranslationArray($translation, $defaultLocale)) {
                $translation->save();
            }
        }
    }

    /**
     * @param Translation $translation
     * @param $locale
     * @return bool
     */
    protected function isCurrentTransForTranslationArray(Translation $translation, string $locale): bool
    {
        if ($translation->group === '*') {
            return is_array(__($translation->key, [], $locale));
        }

        if ($translation->namespace === '*') {
            return is_array(trans($translation->group . '.' . $translation->key, [], $locale));
        }

        return is_array(trans($translation->namespace . '::' . $translation->group . '.' . $translation->key, [], $locale));
    }
}
