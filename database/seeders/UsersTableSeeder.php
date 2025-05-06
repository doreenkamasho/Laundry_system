<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $customerRole = Role::where('name', 'customer')->first();
        $laundressRole = Role::where('name', 'laundress')->first();

        // Create admin users
        User::create([
            'name' => 'Doreen',
            'email' => 'doreen@admin.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Belinda',
            'email' => 'belinda@admin.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        // Create customer
        User::create([
            'name' => 'Poka',
            'email' => 'poka@customer.com',
            'password' => Hash::make('password123'),
            'role_id' => $customerRole->id,
            'is_active' => true,
        ]);

        // Create laundress
        User::create([
            'name' => 'Gerald',
            'email' => 'gerald@laundress.com',
            'password' => Hash::make('password123'),
            'role_id' => $laundressRole->id,
            'is_active' => true,
        ]);
    }
}