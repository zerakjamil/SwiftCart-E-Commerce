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
        Permission::create(['name' => 'create admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete admins', 'guard_name' => 'admin']);

        $superadminRole = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        $superadminRole->givePermissionTo(['create admins', 'edit admins', 'delete admins']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $adminRole->givePermissionTo(['edit admins']);

        if (app()->environment('local') && env('ALLOW_ADMIN_SEEDING', false)) {
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
