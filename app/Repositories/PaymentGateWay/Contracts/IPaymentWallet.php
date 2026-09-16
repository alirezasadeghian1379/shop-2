<?php

namespace App\Repositories\PaymentGateWay\Contracts;

interface IPaymentWallet
{
    public function getName():string;
    public function payWithWallet(float $amount,string $description): bool;
}
