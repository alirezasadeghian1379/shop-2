<?php

namespace App\Enums\User;

enum UserRoleTypeEnum
{
    const USER = 'USER';
    const ADMIN = 'ADMIN';
    const SUPER_ADMIN = 'SUPER_ADMIN';

    static public function getTypes():array
    {
        return [
            self::USER,
            self::ADMIN,
            self::SUPER_ADMIN,
        ];
    }
    public static function getRoleTypesPersian() :array
    {
        return [
            self::USER => __('web/dashboard.enums.roleType.user_text'),
            self::ADMIN => __('web/dashboard.enums.roleType.admin_text'),
            self::SUPER_ADMIN => __('web/dashboard.enums.roleType.super_admin_text'),
        ];
    }
}
