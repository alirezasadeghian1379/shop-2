<?php

namespace App\Policies;


use App\Enums\User\UserRoleTypeEnum;
use App\Repositories\Role\Models\Role;

class RolePolicy
{
    public function view($authUser, Role $role): bool
    {
        if ($role->name === 'Super Admin') {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }

    public function update($authUser, Role $role): bool
    {
        if ($role->name === 'Super Admin') {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }
    public function destroy($authUser, Role $role): bool
    {
        if ($role->name === 'Super Admin') {
            return $authUser->role_type === UserRoleTypeEnum::SUPER_ADMIN;
        }
        return true;
    }
}
