<?php

namespace App\Repositories\PaymentGateWay\Contracts;


use App\Repositories\PaymentGateWay\Models\PaymentCallbackDto;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayPay;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayResult;

interface IPaymentGateWay
{
    public function getName():string;
    public function pay(int $amount,string $description,string $callbackUrl): PaymentGateWayPay;
    public function verify(int $amount,string $authority): PaymentGateWayResult;
    public function parseCallback(array $data): PaymentCallbackDto;
}
