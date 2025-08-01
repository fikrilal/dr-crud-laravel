<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Drug;

echo "=== TESTING DIRECT DRUG CREATION ===\n\n";

try {
    $testData = [
        'kd_obat' => 'TEST001',
        'nm_obat' => 'Test Drug',
        'jenis' => 'Test Category',
        'satuan' => 'Tablet',
        'harga_beli' => 1000,
        'harga_jual' => 1500,
        'stok' => 10,
        'min_stock_level' => 5,
        'kd_supplier' => 'SUP001',
        'status' => 'active',
        'description' => 'Test description',
        'tanggal_kadaluarsa' => '2025-12-31',
        'efek_samping' => 'Test side effects',
        'kontraindikasi' => 'Test contraindications',
        'dosis_dewasa' => 'Test adult dose',
        'dosis_anak' => 'Test child dose',
    ];
    
    echo "Creating drug with data:\n";
    print_r($testData);
    
    $drug = Drug::create($testData);
    
    echo "\nCreated drug in database:\n";
    echo "Drug Code: " . $drug->kd_obat . "\n";
    echo "Drug Name: " . $drug->nm_obat . "\n";
    echo "Expiry Date: " . ($drug->tanggal_kadaluarsa ?? 'NULL') . "\n";
    echo "Side Effects: " . ($drug->efek_samping ?? 'NULL') . "\n";
    echo "Contraindications: " . ($drug->kontraindikasi ?? 'NULL') . "\n";
    echo "Adult Dosage: " . ($drug->dosis_dewasa ?? 'NULL') . "\n";
    echo "Child Dosage: " . ($drug->dosis_anak ?? 'NULL') . "\n";
    
    echo "\nRetrieving from database to double-check:\n";
    $retrieved = Drug::where('kd_obat', 'TEST001')->first();
    echo "Retrieved Expiry Date: " . ($retrieved->tanggal_kadaluarsa ?? 'NULL') . "\n";
    echo "Retrieved Side Effects: " . ($retrieved->efek_samping ?? 'NULL') . "\n";
    echo "Retrieved Contraindications: " . ($retrieved->kontraindikasi ?? 'NULL') . "\n";
    echo "Retrieved Adult Dosage: " . ($retrieved->dosis_dewasa ?? 'NULL') . "\n";
    echo "Retrieved Child Dosage: " . ($retrieved->dosis_anak ?? 'NULL') . "\n";
    
    // Clean up
    $drug->delete();
    echo "\nTest drug deleted.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== END OF TEST ===\n";
