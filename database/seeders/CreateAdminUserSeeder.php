<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin1@admin.com')->first();
        if (!$user) {
            $user = User::create([
                'email' => 'admin1@admin.com',
                'password' => bcrypt('P@ssw0rd'),
                'name' => 'Admin 1',
                'username' => 'admin1',
                // 'status' => 'active',
            ]);
        }
        $role = Role::where('name', 'Admin')->first();
        if (!$role) {
            $role = Role::create(['name' => 'Admin']);
        }
        $user->assignRole([$role->id]);
        // $user->assignRole([$role->name]);
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}
