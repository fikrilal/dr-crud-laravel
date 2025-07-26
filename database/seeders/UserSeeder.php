<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@pharmacy.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Pharmacist',
            'email' => 'pharmacist@pharmacy.com',
            'password' => Hash::make('pharmacist123'),
            'user_type' => 'pharmacist',
            'is_active' => true,
        ]);
    }
}
