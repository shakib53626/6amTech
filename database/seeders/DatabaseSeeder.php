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
            "name"     => "Example User",
            "email"    => "example@gmail.com",
            "phone"    => "01784801663",
            "role"     => "user",
            "status"   => "Active",
            "password" => Hash::make('password')
        ]);

    }
}
