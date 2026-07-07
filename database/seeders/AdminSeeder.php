<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@allypay.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123')
            ]
        );

        $role = Role::where('name','admin')
            ->where('guard_name','api')
            ->first();

        $admin->assignRole($role);
    }
}