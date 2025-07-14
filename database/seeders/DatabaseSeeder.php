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
            "name"     => "Shakibul Islam",
            "email"    => "diu.shakib@gmail.com",
            "phone"    => "01784801663",
            "status"   => "Active",
            "password" => Hash::make('password')
        ]);

        $this->call([ RolePermissionSeeder::class ]);
    }
}
