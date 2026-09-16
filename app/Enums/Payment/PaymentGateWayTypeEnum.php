<?php

namespace App\Enums\Payment;

enum PaymentGateWayTypeEnum
{

    const ZARINPAL = 'ZARINPAL';
    const ZIBAL = 'ZIBAL';
    const WALLET = 'WALLET';

    public static function geTypes():array
    {
        return array(self::ZARINPAL,self::ZIBAL,self::WALLET);
    }

    public static function geTypesDescription() :array
    {
        return [
            self::ZARINPAL => 'زرینپال',
            self::ZIBAL => 'زیبال',
            self::WALLET => 'کیف پول',
        ];
    }

}
