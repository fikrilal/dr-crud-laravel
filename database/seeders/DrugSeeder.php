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
                'tanggal_kadaluarsa' => '2026-12-31',
                'efek_samping' => 'Ruam kulit, mual (jarang terjadi)',
                'kontraindikasi' => 'Hipersensitif terhadap paracetamol, gangguan hati berat',
                'dosis_dewasa' => '1-2 tablet 3-4 kali sehari',
                'dosis_anak' => '½ tablet 3-4 kali sehari (6-12 tahun)',
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
                'tanggal_kadaluarsa' => '2026-08-15',
                'efek_samping' => 'Diare, mual, muntah, ruam kulit',
                'kontraindikasi' => 'Alergi terhadap penisilin, mononukleosis',
                'dosis_dewasa' => '1 kapsul 3 kali sehari',
                'dosis_anak' => '½ kapsul 3 kali sehari (6-12 tahun)',
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
                'tanggal_kadaluarsa' => '2027-03-20',
                'efek_samping' => 'Mengantuk, mulut kering, sakit kepala',
                'kontraindikasi' => 'Hipersensitif terhadap cetirizine, gangguan ginjal berat',
                'dosis_dewasa' => '1 tablet 1 kali sehari',
                'dosis_anak' => '½ tablet 1 kali sehari (6-12 tahun)',
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
                'tanggal_kadaluarsa' => '2026-11-10',
                'efek_samping' => 'Sakit kepala, diare, mual, pusing',
                'kontraindikasi' => 'Hipersensitif terhadap omeprazole',
                'dosis_dewasa' => '1 kapsul 1 kali sehari sebelum makan',
                'dosis_anak' => 'Tidak direkomendasikan untuk anak <1 tahun',
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
                'tanggal_kadaluarsa' => '2027-01-25',
                'efek_samping' => 'Gangguan pencernaan, mual, sakit kepala',
                'kontraindikasi' => 'Tukak peptik, asma, gangguan ginjal berat',
                'dosis_dewasa' => '1 tablet 3-4 kali sehari sesudah makan',
                'dosis_anak' => '½ tablet 3 kali sehari (>6 tahun)',
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
