<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void 
     */
    public function run()
    {
        $this->call([
            EventSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
          
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
