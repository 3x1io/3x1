<?php

namespace Brackets\AdminTranslations;

use Brackets\AdminTranslations\TranslationLoaders\TranslationLoader;
use Illuminate\Translation\FileLoader;

class TranslationLoaderManager extends FileLoader
{
    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($locale, $group, $namespace = null): array
    {
        $fileTranslations = parent::load($locale, $group, $namespace);

        $loaderTranslations = $this->getTranslationsForTranslationLoaders($locale, $group, $namespace);

        return array_replace_recursive($fileTranslations, $loaderTranslations);
    }

    /**
     * @param string $locale
     * @param string $group
     * @param string $namespace
     * @return array
     */
    protected function getTranslationsForTranslationLoaders(
        string $locale,
        string $group,
        string $namespace
    ): array {
        return collect(config('admin-translations.translation_loaders'))
            ->map(static function (string $className) {
                return app($className);
            })
            ->mapWithKeys(static function (TranslationLoader $translationLoader) use ($locale, $group, $namespace) {
                return $translationLoader->loadTranslations($locale, $group, $namespace);
            })
            ->toArray();
    }
}
