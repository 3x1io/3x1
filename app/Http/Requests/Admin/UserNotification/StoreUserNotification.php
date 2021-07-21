<?php

namespace App\Http\Requests\Admin\UserNotification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreUserNotification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user-notification.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'message' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'url' => ['required', 'string'],
            'type' => ['required', 'string'],
            'user_id' => ['nullable', 'array'],
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
        $sanitized['sender_id'] = auth('admin')->user()->id;
        if(!empty($sanitized['user_id'])){
            $sanitized['user_id'] = $sanitized['user_id']['id'];
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
