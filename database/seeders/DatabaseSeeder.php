<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->create([
            "name"     => "Supper Admin",
            "email"    => "superadmin@gmail.com",
            "phone"    => "01784801663",
            "role"     => "admin",
            "status"   => "Active",
            "password" => Hash::make('password')
        ]);

        User::factory()->create([
            "name"     => "Test User",
            "email"    => "test@example.com",
            "phone"    => "01700000017",
            "role"     => "admin",
            "status"   => "Active",
            "password" => Hash::make('password123')
        ]);

        User::factory()->create([
            "name"     => "Example User",
            "email"    => "example@gmail.com",
            "phone"    => "01580663349",
            "role"     => "user",
            "status"   => "Active",
            "password" => Hash::make('password')
        ]);

    }
}
