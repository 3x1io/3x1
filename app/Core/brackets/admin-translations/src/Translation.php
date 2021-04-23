<?php

namespace Brackets\AdminTranslations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

/**
 * @property mixed namespace
 * @property mixed group
 * @property mixed key
 * @property array text
 */
class Translation extends Model
{
    use SoftDeletes;

    /** @var array */
    public $translatable = ['text'];

    /** @var array */
    public $guarded = ['id'];

    /** @var array */
    protected $casts = ['text' => 'array'];

    /**
     * Boot method to declare event handlers
     */
    public static function boot()
    {
        static::bootTraits();

        static::saved(static function (Translation $translation) {
            $translation->flushGroupCache();
        });

        static::deleted(static function (Translation $translation) {
            $translation->flushGroupCache();
        });
    }

    /**
     * @param string $locale
     * @param string $group
     * @param string $namespace
     * @return array
     */
    public static function getTranslationsForGroupAndNamespace(string $locale, string $group, string $namespace): array
    {
        if ($namespace === '' || $namespace === null) {
            $namespace = '*';
        }
        return Cache::rememberForever(static::getCacheKey($namespace, $group, $locale),
            static function () use ($namespace, $group, $locale) {
                return static::query()
                        ->where('namespace', $namespace)
                        ->where('group', $group)
                        ->get()
                        ->reject(static function (Translation $translation) use ($locale, $group) {
                            return empty($translation->getTranslation($locale, $group));
                        })
                        ->reduce(static function ($translations, Translation $translation) use ($locale, $group) {
                            if ($group === '*') {
                                $translations[$translation->key] = $translation->getTranslation($locale, $group);
                            } else {
                                Arr::set($translations, $translation->key, $translation->getTranslation($locale));
                            }

                            return $translations;
                        }) ?? [];
            });
    }

    /**
     * @param string $namespace
     * @param string $group
     * @param string $locale
     * @return string
     */
    public static function getCacheKey(string $namespace, string $group, string $locale): string
    {
        return "brackets.admin-translations.{$namespace}.{$group}.{$locale}";
    }

    /**
     * @param string $locale
     * @param null|string $group
     *
     * @return string
     */
    public function getTranslation(string $locale, string $group = null): string
    {
        if ($group === '*' && !isset($this->text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->text[$fallback] ?? $this->key;
        }
        return $this->text[$locale] ?? '';
    }

    /**
     * @param string $locale
     * @param string $value
     *
     * @return $this
     */
    public function setTranslation(string $locale, string $value): self
    {
        $this->text = array_merge($this->text ?? [], [$locale => $value]);

        return $this;
    }

    /**
     * Flush cache
     */
    protected function flushGroupCache(): void
    {
        foreach ($this->getTranslatedLocales() as $locale) {
            Cache::forget(static::getCacheKey($this->namespace ?? '*', $this->group,
                $locale));
        }
    }

    /**
     * @return array
     */
    protected function getTranslatedLocales(): array
    {
        return array_keys($this->text);
    }
}
