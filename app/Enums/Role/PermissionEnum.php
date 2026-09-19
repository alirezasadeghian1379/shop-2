<?php

namespace App\Enums\Role;

enum PermissionEnum
{
    const DASHBOARD = 'dashboard';
    const USER = 'user';
    const ADMIN = 'admin';
    const ROLE = 'role';
    const SETTING = 'setting';
    const PROVINCE = 'province';
    const CITY = 'city';
    const QUESTION = 'question';
    const SLIDER = 'slider';
    const NOTIFICATION = 'notification';
    const WHATSAPP = 'whatsapp';


    static function Models(): array
    {
        $models = [
            self::DASHBOARD => [
                'actions' => [
                    'index' => 'صفحه اصلی',
                    'clearCache' => 'خالی کردن کش سایت',
                ]
            ],
            self::USER => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::ADMIN => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::ROLE => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::SETTING => [
                'actions' => [
                    'index' => 'تنظیمات',
                    'update' => 'به روزرسانی',
                    'aboutIndex' => 'تنظیمات درباره ما',
                    'aboutUpdate' => 'به روزرسانی درباره ما',
                    'aiIndex' => 'تنظیمات هوش مصنوعی',
                    'aiUpdate' => 'به روزرسانی هوش مصنوعی',
                    'notificationIndex' => 'تنظیمات نوتیفیکیشن',
                    'notificationUpdate' => 'به روزرسانی نوتیفیکیشن',
                    'paymentIndex' => 'تنظیمات درگاه پرداخت',
                    'paymentUpdate' => 'به روزرسانی درگاه پرداخت',
                    'ruleIndex' => 'تنظیمات قوانین و مقررات',
                    'ruleUpdate' => 'به روزرسانی قوانین و مقررات',
                    'smsIndex' => 'تنظیمات اس ام اس',
                    'smsUpdate' => 'به روزرسانی اس ام اس',
                    'socialIndex' => 'تنظیمات شبکه های مجازی',
                    'socialUpdate' => 'به روزرسانی شبکه های مجازی',
                    'watermarkIndex' => 'تنظیمات واترمارک',
                    'watermarkUpdate' => 'به روزرسانی واترمارک',
                ]
            ],
            self::PROVINCE => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::CITY => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::QUESTION => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::SLIDER => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                ]
            ],
            self::NOTIFICATION => [
                'actions' => [
                    'index' => 'لیست',
                    'create' => 'ایجاد',
                    'store' => 'ثبت',
                    'edit' => 'ویرایش',
                    'update' => 'به روزرسانی',
                    'destroy' => 'حذف',
                    'destroyAll' => 'حذف گروهی',
                ]
            ],
            self::WHATSAPP => [
                'actions' => [
                    'index' => 'گفتگوها',
                    'show' => 'نمایش پیام ها',
                    'store' => 'ایجاد پیام',
                    'status' => 'وضعیت اتصال',
                    'connect' => 'اتصال',
                    'disconnect' => 'قطع',
                    'run' => 'اجرا کردن',
                ]
            ],

        ];
        return $models;
    }

    const ModelsTitle = [
        self::DASHBOARD => 'داشبورد',
        self::USER => 'کاربران',
        self::ADMIN => 'مدیران',
        self::ROLE => 'نقش ها',
        self::SETTING => 'تنظیمات',
        self::PROVINCE => 'استان ها',
        self::CITY => 'شهرها',
        self::QUESTION => 'سوالات متداول',
        self::SLIDER => 'اسلایدر',
        self::NOTIFICATION => 'اعلان ها',
        self::WHATSAPP => 'واتساپ',
    ];
}
