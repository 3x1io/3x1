<?php

namespace Brackets\Translatable;

use Brackets\Translatable\Facades\Translatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class TranslatableFormRequest extends FormRequest
{

    /**
     * Define what locales should be required in store/update requests
     *
     * By default all locales are required
     *
     * @return Collection
     */
    public function defineRequiredLocales() : Collection
    {
        return Translatable::getLocales();
    }

    /**
     * @return mixed
     */
    private function prepareLocalesForRules()
    {
        $required = $this->defineRequiredLocales();

        return Translatable::getLocales()->map(static function ($locale) use ($required) {
            return [
                'locale' => $locale,
                'required' => $required->contains($locale)
            ];
        });
    }

    /**
     * @return mixed
     */
    public function rules()
    {
        $standardRules = collect($this->untranslatableRules());

        $rules = $this->prepareLocalesForRules()->flatMap(function ($locale) {
            return collect($this->translatableRules($locale['locale']))->mapWithKeys(static function ($rule, $ruleKey) use ($locale) {
                if (!$locale['required']) {
                    // TODO add support for rules defined via custom Rule classes

                    if (is_array($rule) && ($key = array_search('required', $rule)) !== false) {
                        unset($rule[$key]);
                        array_push($rule, 'nullable');
                    } elseif (is_string($rule)) {
                        $rule = str_replace('required', 'nullable', $rule);
                    }
                }
                return [$ruleKey.'.'.$locale['locale'] => is_array($rule) ? array_values($rule) : $rule];
            });
        })->merge($standardRules);

        return $rules->toArray();
    }

    public function untranslatableRules()
    {
        return [];
    }

    public function translatableRules($locale)
    {
        return [];
    }
}
