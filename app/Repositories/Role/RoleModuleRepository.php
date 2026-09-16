<?php

namespace App\Repositories\Role;

use App\Enums\User\UserRoleTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Admin\Models\Admin;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Repositories\Role\Models\Permission;
use App\Repositories\Role\Models\Role;
use Illuminate\Support\Collection;
use App\Models\Role as RoleModel;
use Spatie\Permission\Models\Permission as PermissionModel;


class RoleModuleRepository implements IRoleRepository
{
    public function all(): Collection
    {
        $query = RoleModel::with(['permissions', 'users']);
        if (auth()->user()->role_type !== UserRoleTypeEnum::SUPER_ADMIN) {
            $query->where('name', '!=','Super Admin');
        }
        return $query->latest()->get()->map(fn($r) => new Role(
            $r->id,
            $r->name,
            $r->created_at,
            $r->permissions->map(fn ($p) => new Permission(
                $p->id,
                $p->name
            ))->all(),
            $r->users()->get()->map(fn ($u) => new Admin(
                $u->id,
                $u->first_name,
                $u->last_name,
                $u->phone,
                $u->email,
                $u->active,
                $u->role_type,
                $u->created_at,
                null,
                $u->avatar()->first() ? $u->avatar()->latest()->first()->path : null
            ))->all(),
        ));
    }

    public function paginate($perPage): PaginatorAdapter
    {
        $query = RoleModel::with(['permissions', 'users']);
        if (auth()->user()->role_type !== UserRoleTypeEnum::SUPER_ADMIN) {
            $query->where('name', '!=','Super Admin');
        }
        $roles = $query->latest()->paginate($perPage);
        $roles->setCollection(
            $roles->getCollection()->map(
                fn ($r) => new Role(
                    $r->id,
                    $r->name,
                    $r->created_at,
                    $r->permissions->map(fn ($p) => new Permission(
                        $p->id,
                        $p->name
                    ))->all(),
                    $r->users()->get()->map(fn ($u) => new Admin(
                        $u->id,
                        $u->first_name,
                        $u->last_name,
                        $u->phone,
                        $u->email,
                        $u->active,
                        $u->role_type,
                        $u->created_at,
                        null,
                        $u->avatar()->first() ? $u->avatar()->latest()->first()->path : null
                    ))->all(),
                )
            )
        );
        return new EloquentPaginatorAdapter($roles);
    }

    public function findById($id):Role
    {
        $role = RoleModel::with(['permissions','users'])->where('id',$id)->first();
        if (!$role) throw new Exception('اطلاعاتی یافت نشد!',404);
        $permissions = $role->permissions->map(fn($p) => new Permission($p->id, $p->name))->all();
        $users = $role->users->map(fn($u) => new Admin(
            $u->id,
            $u->first_name,
            $u->last_name,
            $u->phone,
            $u->email,
            $u->active,
            $u->role_type,
            $u->created_at,
            null,
            $u->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        ))->all();
        return new Role(
            $role->id,
            $role->name,
            $role->created_at,
            $permissions,
            $users
        );
    }

    public function create($data):Role
    {
        $role = RoleModel::create($data);
        foreach ($data['permissions'] as $item) {
            $newPermissions[] = ['name' => $item,'guard_name' => 'web'];
        }
        PermissionModel::upsert($newPermissions,['name','guard_name'],[]);
        $role->syncPermissions($data['permissions']);
        $permissions = $role->permissions->map(fn($p) => new Permission($p->id, $p->name))->all();
        $users = $role->users->map(fn($u) => new Admin(
            $u->id,
            $u->first_name,
            $u->last_name,
            $u->phone,
            $u->email,
            $u->active,
            $u->role_type,
            $u->created_at,
            null,
            $u->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        ))->all();
        return new Role(
            $role->id,
            $role->name,
            $role->created_at,
            $permissions,
            $users,
        );
    }

    public function update($id, $data):Role
    {
        $role = RoleModel::with(['permissions','users'])->where('id',$id)->first();
        if (!$role) throw new Exception('اطلاعاتی یافت نشد!',404);
        $role->update($data);
        foreach ($data['permissions'] as $item) {
            $newPermissions[] = ['name' => $item,'guard_name' => 'web'];
        }
        PermissionModel::upsert($newPermissions,['name','guard_name'],[]);
        $role->syncPermissions($data['permissions']);
        $permissions = $role->permissions->map(fn($p) => new Permission($p->id, $p->name))->all();
        $users = $role->users->map(fn($u) => new Admin(
            $u->id,
            $u->first_name,
            $u->last_name,
            $u->phone,
            $u->email,
            $u->active,
            $u->role_type,
            $u->created_at,
            null,
            $u->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        ))->all();
        return new Role(
            $role->id,
            $role->name,
            $role->created_at,
            $permissions,
            $users
        );
    }

    public function destroy($id):bool
    {
        $role = RoleModel::with(['permissions'])->where('id',$id)->first();
        if (!$role) throw new Exception('اطلاعاتی یافت نشد!',404);
        if ($role->users()->count() == 0){
            $role->delete();
            return true;
        } else {
            throw new Exception('برای نقش مورد نظر کاربر ثبت شده و قابلیت حذف وجود ندارد',422);
        }
    }
}
