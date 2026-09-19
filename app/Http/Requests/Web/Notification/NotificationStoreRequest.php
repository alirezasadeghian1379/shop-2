<?php

namespace App\Http\Requests\Web\Notification;

use App\Enums\Notification\NotificationTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class NotificationStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $isGlobal = 'nullable';
        if (isset($this->is_global) && $this->is_global == 'on'){
            $isGlobal = 'required';
        }
        return [
            'title' => 'required|min:2|max:600',
            'message' => 'required|min:3|max:1000',
            'link' => 'nullable|url',
            'type' => ['required','in:'.implode(',',NotificationTypeEnum::getTypes())],
            'user_ids' => $isGlobal
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
