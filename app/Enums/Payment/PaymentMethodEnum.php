<?php

namespace App\Enums\Payment;

enum PaymentMethodEnum
{

    const WALLET = 'WALLET';
    const GATEWAY = 'GATEWAY';

    public static function getMethods():array
    {
        return array(self::WALLET,self::GATEWAY);
    }

    public static function getMethodsDescription() :array
    {
        return [
            self::WALLET => __('dashboard::app.enums.paymentMethod.wallet_text'),
            self::GATEWAY => __('dashboard::app.enums.paymentMethod.gateway_text'),
        ];
    }

}
