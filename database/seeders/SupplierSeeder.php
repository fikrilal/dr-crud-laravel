<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'kd_supplier' => 'SUP001',
                'nm_supplier' => 'PT Kimia Farma',
                'alamat' => 'Jl. Veteran No. 1, Jakarta',
                'kota' => 'Jakarta',
                'telpon' => '021-1234567',
                'email' => 'info@kimiafarma.co.id',
                'contact_person' => 'Ahmad Sutanto',
                'status' => 'active',
            ],
            [
                'kd_supplier' => 'SUP002',
                'nm_supplier' => 'PT Kalbe Farma',
                'alamat' => 'Jl. Letjen Suprapto Kav. 4, Jakarta',
                'kota' => 'Jakarta',
                'telpon' => '021-7654321',
                'email' => 'sales@kalbe.co.id',
                'contact_person' => 'Siti Nurhaliza',
                'status' => 'active',
            ],
            [
                'kd_supplier' => 'SUP003',
                'nm_supplier' => 'PT Sanbe Farma',
                'alamat' => 'Jl. Mayjen Sutoyo No. 50, Bandung',
                'kota' => 'Bandung',
                'telpon' => '022-7778889',
                'email' => 'contact@sanbe.co.id',
                'contact_person' => 'Budi Santoso',
                'status' => 'active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
