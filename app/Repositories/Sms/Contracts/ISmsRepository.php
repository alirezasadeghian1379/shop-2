<?php

namespace App\Repositories\Sms\Contracts;

use App\Repositories\Sms\Models\Sms;

interface ISmsRepository
{
    public function sendGroup(string $message,array $mobiles,?string $dateTime): Sms;
    public function sendVerify(string $mobile, int $templateId,array $parameters):Sms;
    public function sendApi(string $mobile,string $message):Sms;
}
