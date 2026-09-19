<?php
namespace App\Enums\Setting;

enum SettingSocialEnum
{
    const INSTAGRAM = 'INSTAGRAM';
    const TELEGRAM = 'TELEGRAM';
    const WHATSAPP = 'WHATSAPP';
    const RUBIKA = 'RUBIKA';
    const EITAA = 'EITAA';
    const BALE = 'BALE';
    const SOROUSH_PLUS = 'SOROUSH_PLUS';

    public static function getTypes()
    {
        return [
            self::INSTAGRAM,
            self::TELEGRAM,
            self::WHATSAPP,
            self::RUBIKA,
            self::EITAA,
            self::BALE,
            self::SOROUSH_PLUS,
        ];
    }
    public static function getTypesPersian()
    {
        return [
            ['key' => self::INSTAGRAM , 'value' => 'اینستاگرام'],
            ['key' => self::TELEGRAM , 'value' => 'تلگرام'],
            ['key' => self::WHATSAPP , 'value' => 'واتساپ'],
            ['key' => self::RUBIKA , 'value' => 'روبیکا'],
            ['key' => self::EITAA , 'value' => 'ایتا'],
            ['key' => self::BALE , 'value' => 'بله'],
            ['key' => self::SOROUSH_PLUS , 'value' => 'سروش پلاس'],
        ];
    }
}
