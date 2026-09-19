<?php

namespace App\Http\Requests\Web\Messenger;

use Illuminate\Foundation\Http\FormRequest;

class WhatsappStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:32', 'regex:/^[0-9+]+$/'],
            'message' => ['nullable', 'required_without:media', 'string', 'max:4000'],
            'media' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:51200'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
