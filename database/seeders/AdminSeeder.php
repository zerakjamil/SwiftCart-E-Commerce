<?php

namespace Database\Seeders;

use App\Models\Admin\V1\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete', 'guard_name' => 'admin']);

        $superadminRole = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        $superadminRole->givePermissionTo(['create', 'edit', 'delete']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $adminRole->givePermissionTo(['edit']);

        if (app()->environment('local') && env('ALLOW_ADMIN_SEEDING', true)) {
            $superAdmin = Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@tst.com',
                'password' => Hash::make('123'),
            ]);

            $superAdmin->assignRole('superadmin');

            $this->command->info('Super Admin created successfully.');
        } else {
            $this->command->warn('Admin seeding is not allowed in this environment.');
        }
    }
}
