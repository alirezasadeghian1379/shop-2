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


    static function Models(): array
    {
        $models = [
            self::DASHBOARD => [
                'actions' => [
                    'index' => 'صفحه اصلی',
                    'clearCache' => 'خالی کردن کش سایت'
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
                    'index' => 'لیست',
                    'update' => 'به روزرسانی',
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
    ];
}
