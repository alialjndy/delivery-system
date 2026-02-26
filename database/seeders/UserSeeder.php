<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'alialjndy2@gmail.com',
            'password' => Hash::make('newPass123@'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $driver = User::create([
            'name' => 'Driver User',
            'email' => 'alialjndy874@gmail.com',
            'password' => Hash::make('newPass123@'),
            'email_verified_at' => now(),
        ]);
        $driver->assignRole('driver');

        User::factory()->count(10)->create()->map(function ($user) {
            $user->assignRole('customer');
        });
    }
}
