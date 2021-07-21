<?php

namespace App\Http\Requests\Admin\UserNotification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserNotification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user-notification.edit', $this->userNotification);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'message' => ['sometimes', 'string'],
            'icon' => ['sometimes', 'string'],
            'url' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string'],
            'user_id' => ['nullable', 'string'],
            
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
