<?php

namespace Brackets\Translatable\Traits;

use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations as ParentHasTranslations;

trait HasTranslations
{
    use ParentHasTranslations;

    protected $locale;

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, $this->getLocale());
    }

    /**
     * Set the locale of the model
     *
     * This locale would be used when working with translated attributes
     *
     * @param $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get current locale of the model
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Convert the model instance to an array.
     *
     * By default, translations of only current locale of the model of each translated attribute is returned
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        collect($this->getTranslatableAttributes())->map(function ($attribute) use (&$array) {
            $array[$attribute] = $this->getAttributeValue($attribute);
        });
        return $array;
    }

    /**
     * Convert the model instance to an array.
     *
     * Translated columns are returned as arrays.
     *
     * @return array
     */
    public function toArrayAllLocales(): array
    {
        return parent::toArray();
    }

    /**
     * Convert the model instance to JSON.
     *
     * By default, translations of only current locale of the model of each translated attribute is returned
     *
     * @param int $options
     * @throws JsonEncodingException
     * @return string
     *
     */
    public function toJson($options = 0): string
    {
        return parent::toJson($options);
    }

    /**
     * Convert the model instance to JSON.
     *
     * Translated columns are returned as arrays.
     *
     * @param int $options
     * @throws JsonEncodingException
     * @return string
     *
     */
    public function toJsonAllLocales($options = 0): string
    {
        $json = json_encode($this->toArrayAllLocales(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }
}
