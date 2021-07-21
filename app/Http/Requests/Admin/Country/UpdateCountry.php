<?php

namespace App\Http\Requests\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCountry extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.country.edit', $this->country);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', Rule::unique('countries', 'name')->ignore($this->country->getKey(), $this->country->getKeyName()), 'string'],
            'code' => ['sometimes', Rule::unique('countries', 'code')->ignore($this->country->getKey(), $this->country->getKeyName()), 'string'],
            'phone' => ['sometimes', 'string'],
            'lat' => ['nullable', 'string'],
            'lang' => ['nullable', 'string'],
            
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
