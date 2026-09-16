<?php

namespace App\Repositories\PaymentGateWay\Factories;

use App\Repositories\PaymentGateWay\Contracts\IPaymentGateWay;
use App\Repositories\PaymentGateWay\Contracts\IPaymentWallet;
use App\Repositories\PaymentGateWay\Drivers\Wallet;
use App\Repositories\PaymentGateWay\Drivers\ZarinPal;
use App\Repositories\PaymentGateWay\Drivers\Zibal;

class PaymentGateWayRepositoryFactory
{
    public static function make(string $provider = null): IPaymentGateWay|IPaymentWallet
    {
        $provider = $provider ?? config('PaymentGateWay.default');
        return match ($provider) {
            'wallet' => app(Wallet::class),
            'zarinpal' => app(ZarinPal::class),
            'zibal' => app(Zibal::class),
        };
    }
}
