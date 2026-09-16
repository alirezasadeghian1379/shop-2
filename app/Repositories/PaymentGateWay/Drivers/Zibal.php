<?php

namespace App\Repositories\PaymentGateWay\Drivers;

use App\Enums\Payment\PaymentGateWayTypeEnum;
use App\Repositories\PaymentGateWay\Contracts\IPaymentGateWay;
use App\Repositories\PaymentGateWay\Models\PaymentCallbackDto;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayPay;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayResult;
use Illuminate\Support\Facades\Http;

class Zibal implements IPaymentGateWay
{
    public function pay(int $amount, string $description, string $callbackUrl):PaymentGateWayPay
    {
        try {
            $payUrl = config('PaymentGateWay.drivers.zibal.urls.pay');
            $startUrl = config('PaymentGateWay.drivers.zibal.urls.start');
            $merchant_id = config('PaymentGateWay.drivers.zibal.merchant_id');
            $response = Http::post($payUrl, [
                'merchant' => $merchant_id,
                'amount' => $amount,
                'description' => $description,
                'callbackUrl' => $callbackUrl
            ]);
            $result = $response->json();
            return new PaymentGateWayPay(
                $startUrl.$result['trackId'],
                $result['trackId'],
                $result['result'],
                $result['message'],
            );
        } catch (Throwable $exception) {
            return new PaymentGateWayPay(
                null,
                null,
                $exception->getCode(),
                $exception->getMessage(),
            );
        }
    }
    public function verify(int $amount, string $authority): PaymentGateWayResult
    {
        try {
            $verifyUrl = config('PaymentGateWay.drivers.zibal.urls.verify');
            $merchant_id = config('PaymentGateWay.drivers.zibal.merchant_id');
            $response = Http::post($verifyUrl, [
                'merchant' => $merchant_id,
                'amount' => $amount,
                'trackId' => $authority,
            ]);
            $result = $response->json();
            if ($result['result'] == 201){
                return new PaymentGateWayResult(
                    $result['result'],
                    $result['message'],
                    null,
                    null,
                    null,
                );
            } else {
                return new PaymentGateWayResult(
                    $result['result'],
                    $result['message'],
                    $result['refNumber'],
                    $result['cardNumber'],
                    null
                );
            }
        } catch (Throwable $exception) {
            return new PaymentGateWayResult(
                $exception->getCode(),
                $exception->getMessage(),
                null,
                null,
                null,
            );
        }
    }

    public function getName(): string
    {
        return PaymentGateWayTypeEnum::ZIBAL;
    }

    public function parseCallback(array $data): PaymentCallbackDto
    {
        return new PaymentCallbackDto(
            authority: $data['trackId'],
            isSuccess: $data['success'] == 1,
            status: $data['status']
        );
    }
}
