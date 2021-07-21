<?php

namespace App\Http\Requests\Admin\AdminUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateAdminUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('admin.admin-user.edit', $this->adminUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'email' => ['sometimes', 'email', Rule::unique('admin_users', 'email')->ignore($this->adminUser->getKey(), $this->adminUser->getKeyName()), 'string'],
            'first_name' => ['nullable', 'string'],
            'forbidden' => ['sometimes', 'boolean'],
            'language' => ['sometimes', 'string'],
            'last_name' => ['nullable', 'string'],
            'password' => ['sometimes', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],

            'roles' => ['sometimes', 'array'],

        ];

        if (Config::get('admin-auth.activation_enabled')) {
            $rules['activated'] = ['required', 'boolean'];
        }

        return $rules;
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getModifiedData(): array
    {
        $data = $this->only(collect($this->rules())->keys()->all());
        if (!Config::get('admin-auth.activation_enabled')) {
            $data['activated'] = true;
        }
        if (array_key_exists('password', $data) && empty($data['password'])) {
            unset($data['password']);
        }
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}
