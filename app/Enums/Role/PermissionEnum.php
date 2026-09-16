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
    ];
}
