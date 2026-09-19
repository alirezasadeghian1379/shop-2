<?php

namespace App\Repositories\User;

use App\Enums\User\UserRoleTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Repositories\User\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Models\User as UserModel;

class UserModuleRepository implements IUserRepository
{
    public function all(): Collection
    {
        $users = UserModel::with(['roles','avatar'])
            ->where('role_type', UserRoleTypeEnum::USER)
            ->latest()
            ->get();
        return $users->map(function ($user) {
            return new User(
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->phone,
                $user->active,
                $user->role_type,
                $user->email,
                $user->created_at,
                $user->updated_at,
                $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
        });
    }
    public function paginate(int $perPage) :PaginatorAdapter
    {
        $users = UserModel::with(['roles','avatar'])
            ->where('role_type',UserRoleTypeEnum::USER)
            ->latest()
            ->paginate($perPage);
        $users->setCollection(
            $users->getCollection()->map(function($user){
                    return new User(
                        $user->id,
                        $user->first_name,
                        $user->last_name,
                        $user->phone,
                        $user->active,
                        $user->role_type,
                        $user->email,
                        $user->created_at,
                        $user->updated_at,
                        $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
            })
        );
        return new EloquentPaginatorAdapter($users);
    }
    public function findById(int $id):User
    {
       $user = UserModel::where('id', $id)->first();
       if (!$user) throw new Exception('اطلاعاتی یافت نشد!',404);
       return new User(
           $user->id,
           $user->first_name,
           $user->last_name,
           $user->phone,
           $user->active,
           $user->role_type,
           $user->email,
           $user->created_at,
           $user->updated_at,
           $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
    public function create(array $data):User
    {
        $user = UserModel::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'role_type' => UserRoleTypeEnum::USER,
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
        ]);
        return new User(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->phone,
            $user->active,
            $user->role_type,
            $user->email,
            $user->created_at,
            $user->updated_at,
            $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
    public function update(int $id, array $data):User
    {
        $user = UserModel::where('id', $id)->first();
        if (!$user) throw new Exception('اطلاعاتی یافت نشد!',404);
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'role_type' => UserRoleTypeEnum::USER,
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
        ]);
        return new User(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->phone,
            $user->active,
            $user->role_type,
            $user->email,
            $user->created_at,
            $user->updated_at,
            $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
    public function destroy(int $id):bool
    {
        $user = UserModel::where('id', $id)->first();
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
    public function updateProfile(int $id,array $data):bool
    {
        $user = UserModel::where('id', $id)->first();
        if (!$user) throw new Exception('اطلاعاتی یافت نشد!',404);
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
      return true;
    }
    public function getAllCount(): int
    {
        $userCount = UserModel::where('role_type',UserRoleTypeEnum::USER)->count();
        return $userCount;
    }
    public function getAllLatestByCount(int $count): Collection
    {
        $users = UserModel::where('role_type',UserRoleTypeEnum::USER)
            ->where('created_at','>',now()->subHours(24))
            ->latest()
            ->take($count)
            ->get();
        return $users->map(function ($user) {
            return new User(
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->phone,
                $user->active,
                $user->role_type,
                $user->email,
                $user->created_at,
                $user->updated_at,
                $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
        });
    }
    public function getActiveComplete(): Collection
    {
        $users = UserModel::with(['roles','avatar'])
            ->where('active',1)
            ->latest()
            ->get();
        return $users->map(function ($user) {
            return new User(
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->phone,
                $user->active,
                $user->role_type,
                $user->email,
                $user->created_at,
                $user->updated_at,
                $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
        });
    }
    public function getAllById(array $ids): Collection
    {
        $users = UserModel::whereIn('id',$ids)
            ->with(['roles','avatar'])
            ->where('active',1)
            ->latest()
            ->get();
        return $users->map(function ($user) {
            return new User(
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->phone,
                $user->active,
                $user->role_type,
                $user->email,
                $user->created_at,
                $user->updated_at,
                $user->avatar()->get()->map(fn($avatar) => new GalleryDb(
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
        });
    }
}
