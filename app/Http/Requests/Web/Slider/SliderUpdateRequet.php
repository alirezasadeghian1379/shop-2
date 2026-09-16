<?php

namespace App\Http\Requests\Web\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'link' => 'nullable|url',
            'expired_at' => 'required',
            'description' => 'nullable|min:3|max:500',
            'image' => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:102400',
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
