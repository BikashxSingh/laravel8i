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
        //
        $user = User::create([
            'name' => 'Bikash Singh',
            'username' => 'bikash', 
            'email' => 'bikash@gmail.com',
            'password' => bcrypt('0000')
        ]);
    
        $role = Role::create(['name' => 'Admin']);
     
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::all();
   
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
  
    }
}
