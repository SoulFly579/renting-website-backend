<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        \App\Models\User::factory()->create([
             'full_name' => 'Test User',
             'email' => 'test@example.com'
         ]);

        Role::create([
            "name"=>"user"
        ]);
        Role::create([
            "name"=>"renter"
        ]);
        Role::create([
            "name"=>"admin"
        ]);
    }
}
