<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateSuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@admin.com')->first();
        if (!$user) {
            $user = User::create([
                'email' => 'admin@admin.com',
                'password' => bcrypt('P@ssw0rd'),
                'name' => 'Super Admin',
                'username' => 'superadmin',
                // 'status' => 'active',
            ]);
        }
        $role = Role::where('name', 'SuperAdmin')->first();
        if (!$role) {
            $role = Role::create(['name' => 'SuperAdmin']);
        }
        $user->assignRole([$role->name]);
        // $user->assignRole([$role->id]);
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}
