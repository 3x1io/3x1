<?php

namespace App\Http\Requests\Admin\Medium;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateMedium extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.medium.edit', $this->medium);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'collection_name' => ['sometimes', 'string'],
            'conversions_disk' => ['nullable', 'string'],
            'disk' => ['sometimes', 'string'],
            'file_name' => ['sometimes', 'string'],
            'mime_type' => ['nullable', 'string'],
            'model_id' => ['sometimes', 'string'],
            'model_type' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string'],
            'order_column' => ['nullable', 'integer'],
            'size' => ['sometimes', 'string'],
            'uuid' => ['nullable', Rule::unique('media', 'uuid')->ignore($this->medium->getKey(), $this->medium->getKeyName()), 'string'],


        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'custom_properties' => ['sometimes', 'string'],
            'generated_conversions' => ['sometimes', 'string'],
            'manipulations' => ['sometimes', 'string'],
            'responsive_images' => ['sometimes', 'string'],

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
