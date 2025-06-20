<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'),
            'role_id' => 1,
        ]);

        //Sales Person
        User::create([
            'name' => 'Sales Person',
            'email' => 'salesperson@example.com',
            'password' => Hash::make('salesperson@123'),
            'role_id' => 3,
        ]);

    }
}
