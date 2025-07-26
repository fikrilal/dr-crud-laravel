<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
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

        // Create sample customers first
        $customer1 = Customer::create([
            'kd_pelanggan' => 'CUST001',
            'nm_pelanggan' => 'John Smith',
            'alamat' => '123 Main Street, Downtown',
            'kota' => 'New York',
            'telpon' => '+1-555-0123',
            'email' => 'john.smith@email.com',
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'L',
            'status' => 'active',
        ]);

        $customer2 = Customer::create([
            'kd_pelanggan' => 'CUST002',
            'nm_pelanggan' => 'Sarah Johnson',
            'alamat' => '456 Oak Avenue, Riverside',
            'kota' => 'Los Angeles',
            'telpon' => '+1-555-0456',
            'email' => 'sarah.johnson@email.com',
            'tanggal_lahir' => '1985-12-03',
            'jenis_kelamin' => 'P',
            'status' => 'active',
        ]);

        // Create customer users linked to customer records
        User::create([
            'name' => 'John Smith',
            'email' => 'customer@pharmacy.com',
            'password' => Hash::make('customer123'),
            'user_type' => 'customer',
            'kd_pelanggan' => $customer1->kd_pelanggan,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@pharmacy.com',
            'password' => Hash::make('customer123'),
            'user_type' => 'customer',
            'kd_pelanggan' => $customer2->kd_pelanggan,
            'is_active' => true,
        ]);
    }
}
