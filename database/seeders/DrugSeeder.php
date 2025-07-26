<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drug;
use App\Models\Supplier;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing suppliers
        $suppliers = Supplier::all();
        
        if ($suppliers->isEmpty()) {
            $this->command->warn('No suppliers found. Creating default supplier...');
            $supplier = Supplier::create([
                'kd_supplier' => 'SUP001',
                'nm_supplier' => 'Kimia Farma',
                'alamat' => 'Jl. Veteran No. 9, Jakarta',
                'kota' => 'Jakarta',
                'telpon' => '021-3441991',
                'email' => 'info@kimiafarma.co.id',
                'status' => 'active',
            ]);
            $suppliers = collect([$supplier]);
        }

        $drugs = [
            [
                'kd_obat' => 'OBT001',
                'nm_obat' => 'Paracetamol 500mg',
                'jenis' => 'Analgesik',
                'satuan' => 'Tablet',
                'harga_beli' => 500,
                'harga_jual' => 750,
                'stok' => 100,
                'min_stock_level' => 20,
                'description' => 'Obat penurun panas dan pereda nyeri. Efektif untuk demam, sakit kepala, dan nyeri ringan hingga sedang.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT002',
                'nm_obat' => 'Amoxicillin 500mg',
                'jenis' => 'Antibiotik',
                'satuan' => 'Kapsul',
                'harga_beli' => 2000,
                'harga_jual' => 3000,
                'stok' => 75,
                'min_stock_level' => 15,
                'description' => 'Antibiotik untuk mengobati infeksi bakteri seperti infeksi saluran pernapasan, telinga, dan kulit.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT003',
                'nm_obat' => 'Cetirizine 10mg',
                'jenis' => 'Antihistamin',
                'satuan' => 'Tablet',
                'harga_beli' => 800,
                'harga_jual' => 1200,
                'stok' => 60,
                'min_stock_level' => 10,
                'description' => 'Obat anti alergi untuk mengatasi gatal-gatal, bersin-bersin, dan mata berair akibat alergi.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT004',
                'nm_obat' => 'Omeprazole 20mg',
                'jenis' => 'Gastroprotektan',
                'satuan' => 'Kapsul',
                'harga_beli' => 1500,
                'harga_jual' => 2250,
                'stok' => 45,
                'min_stock_level' => 12,
                'description' => 'Obat untuk mengurangi asam lambung, mengobati maag, GERD, dan tukak lambung.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT005',
                'nm_obat' => 'Ibuprofen 400mg',
                'jenis' => 'NSAID',
                'satuan' => 'Tablet',
                'harga_beli' => 700,
                'harga_jual' => 1050,
                'stok' => 80,
                'min_stock_level' => 18,
                'description' => 'Anti inflamasi non steroid untuk mengurangi nyeri, demam, dan peradangan.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT006',
                'nm_obat' => 'Vitamin C 1000mg',
                'jenis' => 'Vitamin',
                'satuan' => 'Tablet',
                'harga_beli' => 300,
                'harga_jual' => 500,
                'stok' => 120,
                'min_stock_level' => 25,
                'description' => 'Suplemen vitamin C untuk meningkatkan daya tahan tubuh dan kesehatan kulit.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT007',
                'nm_obat' => 'Dextromethorphan Syrup',
                'jenis' => 'Antitusif',
                'satuan' => 'Sirup',
                'harga_beli' => 3000,
                'harga_jual' => 4500,
                'stok' => 35,
                'min_stock_level' => 8,
                'description' => 'Obat batuk kering dalam bentuk sirup, efektif untuk meredakan batuk tidak berdahak.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT008',
                'nm_obat' => 'Salbutamol Inhaler',
                'jenis' => 'Bronkodilator',
                'satuan' => 'Inhaler',
                'harga_beli' => 15000,
                'harga_jual' => 22500,
                'stok' => 25,
                'min_stock_level' => 5,
                'description' => 'Inhaler untuk mengatasi sesak napas pada asma dan penyakit paru obstruktif kronik.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT009',
                'nm_obat' => 'Metformin 500mg',
                'jenis' => 'Antidiabetik',
                'satuan' => 'Tablet',
                'harga_beli' => 1200,
                'harga_jual' => 1800,
                'stok' => 55,
                'min_stock_level' => 15,
                'description' => 'Obat diabetes tipe 2 untuk mengontrol kadar gula darah.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT010',
                'nm_obat' => 'Amlodipine 5mg',
                'jenis' => 'Antihipertensi',
                'satuan' => 'Tablet',
                'harga_beli' => 1800,
                'harga_jual' => 2700,
                'stok' => 40,
                'min_stock_level' => 10,
                'description' => 'Obat hipertensi untuk menurunkan tekanan darah tinggi.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT011',
                'nm_obat' => 'Loratadine 10mg',
                'jenis' => 'Antihistamin',
                'satuan' => 'Tablet',
                'harga_beli' => 900,
                'harga_jual' => 1350,
                'stok' => 65,
                'min_stock_level' => 12,
                'description' => 'Obat alergi untuk mengatasi rinitis alergi dan urtikaria tanpa menyebabkan kantuk.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT012',
                'nm_obat' => 'Simvastatin 20mg',
                'jenis' => 'Statin',
                'satuan' => 'Tablet',
                'harga_beli' => 2500,
                'harga_jual' => 3750,
                'stok' => 30,
                'min_stock_level' => 8,
                'description' => 'Obat untuk menurunkan kolesterol tinggi dan mencegah penyakit jantung.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT013',
                'nm_obat' => 'Antacid Tablet',
                'jenis' => 'Antasida',
                'satuan' => 'Tablet',
                'harga_beli' => 400,
                'harga_jual' => 600,
                'stok' => 90,
                'min_stock_level' => 20,
                'description' => 'Tablet antasida untuk menetralkan asam lambung dan meredakan nyeri ulu hati.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT014',
                'nm_obat' => 'Betadine Solution',
                'jenis' => 'Antiseptik',
                'satuan' => 'Botol',
                'harga_beli' => 5000,
                'harga_jual' => 7500,
                'stok' => 50,
                'min_stock_level' => 10,
                'description' => 'Larutan antiseptik untuk membersihkan luka dan mencegah infeksi.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT015',
                'nm_obat' => 'Diclofenac Gel',
                'jenis' => 'NSAID Topikal',
                'satuan' => 'Tube',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'stok' => 20,
                'min_stock_level' => 5,
                'description' => 'Gel anti inflamasi untuk nyeri sendi, keseleo, dan cedera otot.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT016',
                'nm_obat' => 'Multivitamin Tablet',
                'jenis' => 'Vitamin',
                'satuan' => 'Tablet',
                'harga_beli' => 600,
                'harga_jual' => 900,
                'stok' => 85,
                'min_stock_level' => 20,
                'description' => 'Suplemen multivitamin lengkap untuk menjaga kesehatan tubuh secara keseluruhan.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT017',
                'nm_obat' => 'Ciprofloxacin 500mg',
                'jenis' => 'Antibiotik',
                'satuan' => 'Tablet',
                'harga_beli' => 3500,
                'harga_jual' => 5250,
                'stok' => 15,
                'min_stock_level' => 5,
                'description' => 'Antibiotik spektrum luas untuk infeksi saluran kemih dan infeksi bakteri lainnya.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT018',
                'nm_obat' => 'Calcium Carbonate',
                'jenis' => 'Suplemen',
                'satuan' => 'Tablet',
                'harga_beli' => 800,
                'harga_jual' => 1200,
                'stok' => 70,
                'min_stock_level' => 15,
                'description' => 'Suplemen kalsium untuk kesehatan tulang dan gigi.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT019',
                'nm_obat' => 'Hydrocortisone Cream',
                'jenis' => 'Kortikosteroid',
                'satuan' => 'Tube',
                'harga_beli' => 6000,
                'harga_jual' => 9000,
                'stok' => 25,
                'min_stock_level' => 6,
                'description' => 'Krim kortikosteroid untuk mengatasi eksim, dermatitis, dan peradangan kulit.',
                'status' => 'active',
            ],
            [
                'kd_obat' => 'OBT020',
                'nm_obat' => 'Zinc Tablet',
                'jenis' => 'Suplemen',
                'satuan' => 'Tablet',
                'harga_beli' => 500,
                'harga_jual' => 750,
                'stok' => 95,
                'min_stock_level' => 20,
                'description' => 'Suplemen zinc untuk meningkatkan sistem imun dan mempercepat penyembuhan luka.',
                'status' => 'active',
            ],
        ];

        foreach ($drugs as $drugData) {
            // Assign random supplier
            $drugData['kd_supplier'] = $suppliers->random()->kd_supplier;
            
            Drug::create($drugData);
        }

        $this->command->info('Created ' . count($drugs) . ' drugs successfully!');
    }
}
