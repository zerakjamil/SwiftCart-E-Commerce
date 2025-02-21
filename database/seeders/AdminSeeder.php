<?php

namespace Database\Seeders;

use App\Models\Admin\V1\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('local') && env('ALLOW_ADMIN_SEEDING', false)) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@tst.com',
                'password' => Hash::make('123'),
            ]);

            $this->command->info('Super Admin created successfully.');
        } else {
            $this->command->warn('Admin seeding is not allowed in this environment.');
        }
    }
}
