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
            self::USER => 'کاربر',
            self::ADMIN => 'ادمین',
            self::SUPER_ADMIN => 'سوپر ادمین',
        ];
    }
}
