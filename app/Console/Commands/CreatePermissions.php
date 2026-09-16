<?php
namespace App\Console\Commands;

use App\Enums\Role\PermissionEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (PermissionEnum::Models() as $model_name => $model) {
            foreach ($model['actions'] as $action_name => $action) {
                Permission::create(['name' => $action_name . ' ' . $model_name]);
            }
        }

        Role::create(['name' => 'Super Admin']);
        $role = Role::where('name', 'Super Admin')->first();
        foreach (Permission::pluck('id')->toArray() as $permission) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission,
                'role_id' => $role->id,
            ]);
        }
        $users = User::where('role_type', 'SUPER_ADMIN')->get();

        foreach ($users as $user) {
            $user->assignRole('Super Admin');
        }
    }
}
