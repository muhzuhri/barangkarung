<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@barangkarung.com',
                'password' => Hash::make('superadmin123'),
                'phone' => '081234567890',
                'role' => 'super_admin',
                'is_active' => true,
                'avatar' => null
            ],
            [
                'name' => 'Admin Utama',
                'email' => 'admin@barangkarung.com',
                'password' => Hash::make('admin123'),
                'phone' => '081234567891',
                'role' => 'admin',
                'is_active' => true,
                'avatar' => null
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@barangkarung.com',
                'password' => Hash::make('moderator123'),
                'phone' => '081234567892',
                'role' => 'moderator',
                'is_active' => true,
                'avatar' => null
            ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}