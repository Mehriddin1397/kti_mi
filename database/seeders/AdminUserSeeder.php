<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['phone' => '+998901234567'],
            [
                'full_name' => 'Bosh Administrator',
                'password' => Hash::make('admin12345'),
                'is_active' => true,
            ]
        );

        if (! $admin->hasRole(Roles::ADMIN)) {
            $admin->assignRole(Roles::ADMIN);
        }
    }
}
