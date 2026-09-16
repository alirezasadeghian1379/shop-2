<?php

namespace App\Policies;

use App\Enums\User\UserRoleTypeEnum;
use App\Repositories\Admin\Models\Admin;


class UserPolicy
{
    public function view($authUser, Admin $admin): bool
    {
        if ($admin->role_type === UserRoleTypeEnum::SUPER_ADMIN) {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }

    public function update($authUser, Admin $admin): bool
    {
        if ($admin->role_type === UserRoleTypeEnum::SUPER_ADMIN) {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }
    public function destroy($authUser, Admin $admin): bool
    {
        if ($admin->role_type === UserRoleTypeEnum::SUPER_ADMIN) {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }
}
