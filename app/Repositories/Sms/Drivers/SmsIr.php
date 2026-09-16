<?php

namespace App\Repositories\Sms\Drivers;

use App\Helpers\Adapters\Exception\Exception;
use App\Repositories\Sms\Contracts\ISmsRepository;
use App\Repositories\Sms\Models\Sms;
use Illuminate\Support\Facades\Http;
use Throwable;

class SmsIr implements ISmsRepository
{
    protected string $apiKey;
    protected string $lineNumber;
    protected string $userName;
    protected string $groupUrl;
    protected string $verifyUrl;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('sms.drivers.smsIr.api_key');
        $this->lineNumber = config('sms.drivers.smsIr.line_number');
        $this->userName = config('sms.drivers.smsIr.user_name');
        $this->groupUrl = config('sms.drivers.smsIr.urls.group');
        $this->verifyUrl = config('sms.drivers.smsIr.urls.verify');
        $this->apiUrl = config('sms.drivers.smsIr.urls.api');
    }

    public function sendGroup(string $message, array $mobiles, ?string $dateTime): Sms
    {
        try {
            $response = Http::withHeaders([
                'ACCEPT' => 'application/json',
                'X-API-KEY' => $this->apiKey,
            ])->post($this->groupUrl, [
                'lineNumber' => $this->lineNumber,
                'MessageText' => $message,
                'Mobiles' => $mobiles,
                'SendDateTime' => $dateTime,
            ]);
            $result = $response->json();
            return new Sms(
                $result['status'],
                $result['message'],
                $result['data']['packId'],
                $result['data']['messageIds'],
                $result['data']['cost'],
            );
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(),$exception->getCode());
        }
    }

    public function sendVerify(string $mobile, int $templateId, array $parameters): Sms
    {
        try {
            $response = Http::withHeaders([
                'ACCEPT' => 'application/json',
                'X-API-KEY' => $this->apiKey,
            ])->post($this->verifyUrl, [
                'Mobile' => $mobile,
                'TemplateId' => $templateId,
                'Parameters' => $parameters,
            ]);
            $result = $response->json();
            return new Sms(
                $result['status'],
                $result['message'],
                null,
                $result['data']['messageId'],
                $result['data']['cost'],
            );
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(),$exception->getCode());
        }
    }

    public function sendApi(string $mobile, string $message): Sms
    {
        try {
            $response = Http::withHeaders([
                'ACCEPT' => 'application/json',
            ])->get($this->apiUrl, [
                'Username' => $this->userName,
                'Password' => $this->apiKey,
                'Line' => $this->lineNumber,
                'Mobile' => $mobile,
                'Text' => $message,
            ]);
            $result = $response->json();
            return new Sms(
                $result['status'],
                $result['message'],
                null,
                $result['data']['messageId'],
                $result['data']['cost'],
            );
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(),$exception->getCode());
        }
    }
}
