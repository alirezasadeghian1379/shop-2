<?php

namespace App\Enums\Gallery;

enum StorageTypeEnum
{
    const LOGO = 'LOGO';
    const ICON = 'ICON';
    const AVATAR = 'AVATAR';
    const PRODUCT = 'PRODUCT';
    const WATERMARK = 'WATERMARK';
    const SLIDER = 'SLIDER';
    const WHATSAPP = 'WHATSAPP';
    const ABOUT = 'ABOUT';

    public static function getTypes()
    {
        return [
            self::LOGO,
            self::ICON,
            self::AVATAR,
            self::PRODUCT,
            self::WATERMARK,
            self::SLIDER,
            self::WHATSAPP,
            self::ABOUT,
        ];
    }

    public static function getTypesPersian()
    {
        return [
            self::LOGO => 'لوگو',
            self::ICON => 'آیکون',
            self::AVATAR => 'تصویر پروفایل کاربران',
            self::PRODUCT => 'محصولات',
            self::WATERMARK => 'واترمارک',
            self::SLIDER => 'اسلایدر',
            self::WHATSAPP => 'تصاویر ارسالی در واتساپ',
            self::ABOUT => 'درباره ما',
        ];
    }
    public static function getAccessWaterMarkTypes()
    {
        return [
            self::LOGO,
            self::ICON,
            self::AVATAR,
            self::PRODUCT,
            self::SLIDER,
            self::WHATSAPP,
            self::ABOUT,
        ];
    }
}
