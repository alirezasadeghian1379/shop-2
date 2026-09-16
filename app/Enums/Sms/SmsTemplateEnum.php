<?php

namespace App\Enums\Sms;

use function Symfony\Component\String\s;

enum SmsTemplateEnum: string
{
    case SEND_OTP = 'SEND_OTP';

    /**
     * کد template مربوط به هر case
     */
    public function getTemplateCode(): int
    {
        return match($this) {
            self::SEND_OTP => 725380,
        };
    }

    /**
     * پارامترهای template
     */
    public function getTemplateParameters(array $data): array
    {
        return match($this) {
            self::SEND_OTP => [
                ['name' => 'CODE', 'value' => $data['code'] ?? ''],
            ],
        };
    }
}
