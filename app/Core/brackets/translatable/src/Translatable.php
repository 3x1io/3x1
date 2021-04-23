<?php

namespace Brackets\Translatable;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Translatable
{
    /**
     * Attempt to get all locales.
     *
     * @return Collection
     */
    public function getLocales(): Collection
    {
        return collect((array)Config::get('translatable.locales'))->map(static function ($val, $key) {
            return is_array($val) ? $key : $val;
        });
    }
}
