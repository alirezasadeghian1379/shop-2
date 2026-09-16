<?php

namespace App\Repositories\Admin;


use App\Enums\User\UserRoleTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Admin\Models\Admin;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Repositories\Role\Models\Permission;
use App\Repositories\Role\Models\Role;
use Illuminate\Support\Facades\File;
use App\Models\Role as RoleModel;
use Illuminate\Support\Collection;
use App\Models\User;

class AdminModuleRepository implements IAdminRepository
{
    public function all(): Collection
    {
        $query = User::whereIn('role_type', [UserRoleTypeEnum::ADMIN, UserRoleTypeEnum::SUPER_ADMIN]);
        if (auth()->user()->role_type !== UserRoleTypeEnum::SUPER_ADMIN) {
            $query->where('role_type', UserRoleTypeEnum::ADMIN);
        }
        $admins = $query->latest()->get()
            ->map(fn($ad) => new Admin(
                $ad->id,
                $ad->first_name,
                $ad->last_name,
                $ad->phone,
                $ad->email,
                $ad->active,
                $ad->role_type,
                $ad->created_at,
                $ad->roles()->latest()->get()->map(fn($role) => new Role(
                    $role->id,
                    $role->name,
                    $role->created_at,
                    $role->permissions()->get()->map(fn($permission) => new Permission(
                        $permission->id,
                        $permission->name,
                    ))->toArray(),
                ))->first(),
                $ad->avatar()->get()->map(fn($avatar) => new GalleryDb(
                    $avatar->id,
                    $avatar->uuid,
                    $avatar->type,
                    $avatar->path,
                    $avatar->item_id,
                    $avatar->registered,
                    $avatar->created_at,
                    $avatar->updated_at,
                ))->first(),
            ));
        return $admins;
    }
    public function paginate(int $perPage): PaginatorAdapter
    {
        $query = User::whereIn('role_type', [UserRoleTypeEnum::ADMIN, UserRoleTypeEnum::SUPER_ADMIN]);
        if (auth()->user()->role_type !== UserRoleTypeEnum::SUPER_ADMIN) {
            $query->where('role_type', UserRoleTypeEnum::ADMIN);
        }
        $admins = $query->latest()->paginate($perPage);
        $admins->setCollection(
            $admins->getCollection()->map(
                fn ($ad) => new Admin(
                    $ad->id,
                    $ad->first_name,
                    $ad->last_name,
                    $ad->phone,
                    $ad->email,
                    $ad->active,
                    $ad->role_type,
                    $ad->created_at,
                    $ad->roles()->latest()->get()->map(fn($role) => new Role(
                        $role->id,
                        $role->name,
                        $role->created_at,
                        $role->permissions()->get()->map(fn($permission) => new Permission(
                            $permission->id,
                            $permission->name,
                        ))->toArray(),
                    ))->first(),
                    $ad->avatar()->get()->map(fn($avatar) => new GalleryDb(
                        $avatar->id,
                        $avatar->uuid,
                        $avatar->type,
                        $avatar->path,
                        $avatar->item_id,
                        $avatar->registered,
                        $avatar->created_at,
                        $avatar->updated_at,
                    ))->first(),
                )
            )
        );
        return new EloquentPaginatorAdapter($admins);
    }
    public function findById(int $id): ?Admin
    {
        $admin = User::where('id',$id)->first();
        if (!$admin) throw new Exception('اطلاعاتی یافت نشد!',404);
        if (!$admin->roles()->exists()) return null;
        $userRole = $admin->roles()->latest()->first();
        $role = new Role(
            $userRole->id,
            $userRole->name,
            $userRole->created_at,
            $userRole->permissions()->get()->map(fn($permission) => new Permission(
                $permission->id,
                $permission->name,
            ))->toArray(),
        );
        return new Admin(
            $admin->id,
            $admin->first_name,
            $admin->last_name,
            $admin->phone,
            $admin->email,
            $admin->active,
            $admin->role_type,
            $admin->created_at,
            $role,
            $admin->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        );
    }
    public function create(array $data): Admin
    {
        $newAdmin = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
            'role_type' => isset($data['role_type']) ? $data['role_type']:UserRoleTypeEnum::ADMIN,
        ]);
        $role = RoleModel::where('name',$data['role_name'])->first();
        if (!$role) throw new Exception('اطلاعاتی یافت نشد!',404);
        $newAdmin->assignRole($role);
        return new Admin(
            $newAdmin->id,
            $newAdmin->first_name,
            $newAdmin->last_name,
            $newAdmin->phone,
            $newAdmin->email,
            $newAdmin->active,
            $newAdmin->role_type,
            $newAdmin->created_at,
            $newAdmin->roles()->latest()->get()->map(fn($role) => new Role(
                $role->id,
                $role->name,
                $role->created_at,
                $role->permissions()->get()->map(fn($permission) => new Permission(
                    $permission->id,
                    $permission->name,
                ))->toArray(),
            ))->first(),
            $newAdmin->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        );
    }
    public function update(int $id,array $data): Admin
    {
        $admin = User::where('id',$id)->first();
        if (!$admin) throw new Exception('اطلاعاتی یافت نشد!',404);
        $admin->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
            'role_type' => isset($data['role_type']) ? $data['role_type']:UserRoleTypeEnum::ADMIN,
        ]);
        $role = RoleModel::where('name',$data['role_name'])->first();
        if (!$role) throw new Exception('اطلاعاتی یافت نشد!',404);
        $admin->syncRoles($role);
        return new Admin(
            $admin->id,
            $admin->first_name,
            $admin->last_name,
            $admin->phone,
            $admin->email,
            $admin->active,
            $admin->role_type,
            $admin->created_at,
            $admin->roles()->latest()->get()->map(fn($role) => new Role(
                $role->id,
                $role->name,
                $role->created_at,
                $role->permissions()->get()->map(fn($permission) => new Permission(
                    $permission->id,
                    $permission->name,
                ))->toArray(),
            ))->first(),
            $admin->avatar()->get()->map(fn($avatar) => new GalleryDb(
                $avatar->id,
                $avatar->uuid,
                $avatar->type,
                $avatar->path,
                $avatar->item_id,
                $avatar->registered,
                $avatar->created_at,
                $avatar->updated_at,
            ))->first(),
        );
    }
    public function destroy(int $id): bool
    {
        $user = User::where('id',$id)->first();
        if (!$user) throw new Exception('اطلاعاتی یافت نشد!',404);
        if ($user->avatar()->count()){
            if (File::exists('storage/'.$user->avatar->path)){
                File::delete('storage/'.$user->avatar->path);
            }
            $user->avatar()->delete();
        }
        $user->delete();
        return true;
    }
}
