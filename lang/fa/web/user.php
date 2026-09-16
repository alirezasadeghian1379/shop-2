<?php

return [
    'title' => 'کاربران',
    'list' => 'لیست کاربران',
    'create' => 'ایجاد کاربر جدید',
    'edit' => 'ویرایش',
    'store' => 'ثبت',
    'destroy' => 'حذف',
    'back' => 'بازگشت',
    'wallet' => 'کیف پول',
    'form' => [
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'phone' => 'شماره همراه',
        'email' => 'ایمیل',
        'gender' => 'جنسیت',
        'active' => 'وضعیت فعال / غیرفعال',
        'date_birth' => 'تاریخ تولد',
        'avatar' => 'تصویر پروفایل',
        'address' => 'آدرس',
        'is_authorized' => 'احراز شده / احراز نشده',
        'select' => [
            'default' => 'انتخاب کنید'
        ]
    ],
    'table' => [
        '#' => '#',
        'image' => 'تصویر',
        'full_name' => 'نام و نام خانوادگی',
        'mobile' => 'موبایل',
        'email' => 'ایمیل',
        'active' => 'وضعیت',
        'created_at' => 'تاریخ ایجاد',
        'setting' => 'عملیات',
    ],
    'table_options' => [
        'active_value' => 'فعال',
        'deActive_value' => 'غیرفعال',
    ],
    'card' => [
        'list' => 'لیست کارت های بانکی',
        'table' => [
            'card_number' => 'شماره کارت',
            'sheba' => 'شماره شبا',
            'bank_name' => 'نام بانک',
            'owner_name' => 'نام صاحب حساب',
            'is_verified' => 'وضعیت',
            'created_at' => 'تاریخ ثبت',
        ],
        'options' => [
            'is_verified' => 'تایید شده',
            'not_verified' => 'در انتظار تایید',
            'is_verify' => 'تایید کردن',
            'not_verify' => 'رد کردن',
        ]
    ],
    'auth' => [
        'list' => 'تصاویر احراز کاربر',
        'backNationalCard' => 'تصویر پشت کارت ملی',
        'frontNationalCard' => 'تصویر روی کارت ملی',
        'selfie' => 'تصویر سلفی',
        'download' => 'دانلود'
    ]
];
