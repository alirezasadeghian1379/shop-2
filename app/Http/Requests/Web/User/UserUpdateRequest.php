<?php

namespace App\Http\Requests\Web\User;

use App\Enums\User\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['required','min:11','max:11','ir_mobile',Rule::unique('users','phone')->ignore($this->user)],
            'email' => ['nullable','email',Rule::unique('users','email')->ignore($this->user)],
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
