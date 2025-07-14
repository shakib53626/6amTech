<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = Role::create([
            'name' => 'Supper Admin',
            'slug' => 'supperadmin'
        ]);

        $permissions = [
            'users-read',        'users-create',       'users-update',        'users-delete',
            'roles-read',        'roles-create',       'roles-update',        'roles-delete',
            'permissions-read',  'permissions-create', 'permissions-update',  'permissions-delete'
        ];

        foreach ($permissions as $permission) {
            $p = Permission::create(['name' => $permission]);
            $adminRole->permissions()->attach($p->id);
        }

        $user = User::find(1);
        $user->roles()->attach($adminRole->id);
    }
}
