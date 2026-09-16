<?php

namespace App\Enums\Gallery;

enum StorageTypeEnum
{
    const LOGO = 'LOGO';
    const ICON = 'ICON';
    const AVATAR = 'AVATAR';
    const PRODUCT = 'PRODUCT';
    const WATERMARK = 'WATERMARK';

    public static function getTypes()
    {
        return [
            self::LOGO,
            self::ICON,
            self::AVATAR,
            self::PRODUCT,
            self::WATERMARK,
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
        ];
    }
    public static function getAccessWaterMarkTypes()
    {
        return [
            self::LOGO,
            self::ICON,
            self::AVATAR,
            self::PRODUCT,
        ];
    }
}
