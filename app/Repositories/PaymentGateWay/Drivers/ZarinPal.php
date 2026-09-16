<?php

namespace App\Repositories\PaymentGateWay\Drivers;

use App\Enums\Payment\PaymentGateWayTypeEnum;
use App\Repositories\PaymentGateWay\Contracts\IPaymentGateWay;
use App\Repositories\PaymentGateWay\Models\PaymentCallbackDto;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayPay;
use App\Repositories\PaymentGateWay\Models\PaymentGateWayResult;
use Illuminate\Support\Facades\Http;
use Throwable;

class ZarinPal implements IPaymentGateWay
{
    public function pay(int $amount, string $description, string $callbackUrl):PaymentGateWayPay
    {
        try {
            $payMode = config('PaymentGateWay.drivers.zarinpal.mode');
            $payUrl = config('PaymentGateWay.drivers.zarinpal.urls.'.$payMode.'.pay');
            $startUrl = config('PaymentGateWay.drivers.zarinpal.urls.'.$payMode.'.start');
            $merchant_id = config('PaymentGateWay.drivers.zarinpal.merchant_id');
            $response = Http::post($payUrl, [
                'merchant_id' => $merchant_id,
                'amount' => $amount*10,
                'description' => $description,
                'callback_url' => $callbackUrl
            ]);
            $result = $response->json()['data'];
            return new PaymentGateWayPay(
                $startUrl.$result['authority'],
                $result['authority'],
                $result['code'],
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
            $payMode = config('PaymentGateWay.drivers.zarinpal.mode');
            $verifyUrl = config('PaymentGateWay.drivers.zarinpal.urls.'.$payMode.'.verify');
            $merchant_id = config('PaymentGateWay.drivers.zarinpal.merchant_id');
            $response = Http::post($verifyUrl, [
                'merchant_id' => $merchant_id,
                'amount' => $amount*10,
                'authority' => $authority,
            ]);
            $result = $response->json()['data'];
            return new PaymentGateWayResult(
                $result['code'],
                $result['message'],
                $result['ref_id'],
                $result['card_pan'],
                $result['fee'],
            );
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
        return PaymentGateWayTypeEnum::ZARINPAL;
    }

    public function parseCallback(array $data): PaymentCallbackDto
    {
        return new PaymentCallbackDto(
            authority: $data['Authority'],
            isSuccess: $data['Status'] === 'OK',
            status:null
        );
    }
}
