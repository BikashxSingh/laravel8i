<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SuperAdmin',
            'Admin',
        ];
        $roles_all = Role::get()->pluck('name')->toArray();
        foreach ($roles as $role) {
            if (!in_array($role, $roles_all)) {
                Role::create([
                    'name' => $role
                ]);
            }
        }
    }
}
