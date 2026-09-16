<?php

namespace App\Services;

use App\Enums\Sms\SmsTemplateEnum;
use App\Repositories\Sms\Factories\SmsRepositoryFactory;
use App\Repositories\Sms\Models\Sms;

class SmsService
{
    protected $repo;
    public function __construct(?string $smsType)
    {
        $this->repo = SmsRepositoryFactory::make(isset($smsType) ? $smsType:null);
    }

    public function sendGroup(string $message,array $mobiles,?string $dateTime): Sms
    {
        return $this->repo->sendGroup($message,$mobiles,$dateTime);
    }
    public function sendVerify(string $mobile, int $templateId,array $parameters):Sms
    {
        return $this->repo->sendVerify($mobile,$templateId,$parameters);
    }
    public function sendApi(string $mobile,string $message):Sms
    {
        return $this->repo->sendApi($mobile,$message);
    }

    public function sendSmsByStatusType(string $mobile,SmsTemplateEnum $type,array $data):bool
    {
        $templateId = $type->getTemplateCode();
        $templateParameters = $type->getTemplateParameters($data);
        $this->sendVerify($mobile,$templateId,$templateParameters);
        return true;
    }
}
