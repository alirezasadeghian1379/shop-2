<?php

namespace App\Repositories\Role\Models;
use App\Repositories\Admin\Models\Admin;

class Role
{
    public int $id;
    public string $name;
    public string $created_at;

    /** @var Permission[] */
    public array $permissions = [];

    /** @var Admin[] */
    public array $users = [];

    public function __construct(int $id, string $name, string $created_at,array $permissions,array $users = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->permissions = $permissions;
        $this->users = $users;
    }

    public function getAllPermissionNames()
    {
        $permissionNames = [];
        foreach ($this->permissions as $permission) {
            $permissionNames[] = $permission->name;
        }
        return $permissionNames;
    }
    public function getAllUsersCount()
    {
        return count($this->users);
    }
    public function getPermissionsCount()
    {
        return count($this->permissions);
    }
    public function getJalaliCreatedAt()
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }

}
