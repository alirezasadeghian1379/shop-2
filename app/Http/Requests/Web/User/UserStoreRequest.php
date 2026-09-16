<?php

namespace App\Http\Requests\Web\User;

use App\Enums\User\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|min:11|max:11|ir_mobile|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:102400',
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
