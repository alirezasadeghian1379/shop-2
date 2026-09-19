<?php

namespace App\Enums\Notification;

enum NotificationTypeEnum
{

    const SUCCESS = 'SUCCESS';
    const WARNING = 'WARNING';
    const INFO = 'INFO';
    const GRAY = 'GRAY';
    const DANGER = 'DANGER';

    public static function getTypes():array
    {
        return array(self::SUCCESS,self::WARNING,self::INFO,self::GRAY,self::DANGER);
    }

    public static function getTypesDescription() :array
    {
        return [
            self::SUCCESS => 'سبز',
            self::WARNING => 'نارنجی',
            self::INFO => 'آبی',
            self::GRAY => 'طوسی',
            self::DANGER => 'قرمز',
        ];
    }
    public static function getTypesColor() :array
    {
        return [
            self::SUCCESS => 'success',
            self::WARNING => 'warning',
            self::INFO => 'info',
            self::GRAY => 'secondary',
            self::DANGER => 'danger',
        ];
    }

}
