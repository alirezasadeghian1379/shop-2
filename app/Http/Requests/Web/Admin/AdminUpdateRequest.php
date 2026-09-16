<?php

namespace App\Http\Requests\Web\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required','email',Rule::unique('users','email')->ignore($this->admin)],
            'password' => 'nullable|min:5|max:30',
            'phone' => ['required','min:11','max:11','ir_mobile',Rule::unique('users','phone')->ignore($this->admin)],
            'avatar' => 'nullable|mimes:jpeg,jpg,svg,webp,png|max:102400',
            'role_name' => ['required',Rule::exists('roles','name')],
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
