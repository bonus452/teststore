<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$SWHb6owQpq4HLNyt2q/TIe9c2cjf2KP4iGXmYBBitJmB8xS/nE4TC'
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@user.test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$SWHb6owQpq4HLNyt2q/TIe9c2cjf2KP4iGXmYBBitJmB8xS/nE4TC'
        ]);

    }
}
