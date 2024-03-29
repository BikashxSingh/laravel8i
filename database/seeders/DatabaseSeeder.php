<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Message::factory(10)->create();

        $this->call([
            CreateSuperAdminUserSeeder::class,
            CreateAdminUserSeeder::class,
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
