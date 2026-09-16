<?php

namespace Database\Seeders;

use App\Enums\User\UserRoleTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDB = DB::table('users');
        if ($userDB->count() == 0) {
            $users = [
                array(
                    'id' => 1,
                    'first_name' => 'علیرضت',
                    'last_name' => 'صادقیان',
                    'phone' => '09195144947',
                    'email' => 'superadmin@gmail.com',
                    'role_type' => UserRoleTypeEnum::SUPER_ADMIN,
                    'password' => '@Alireza135790#',
                    'active' => 1,
                )
            ];
            foreach ($users as $user) {
                $userDB->insert([
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'phone' => $user['phone'],
                    'email' => $user['email'],
                    'role_type' => $user['role_type'],
                    'password' => Hash::make($user['password']),
                    'active' => $user['active'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
