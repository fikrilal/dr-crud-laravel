<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Drug;

echo "=== COMPREHENSIVE DRUG DATA VERIFICATION ===\n\n";

$drugs = Drug::all();

echo "Total drugs found: " . $drugs->count() . "\n\n";

if ($drugs->isEmpty()) {
    echo "NO DRUGS FOUND IN DATABASE!\n";
    exit;
}

foreach ($drugs as $drug) {
    echo "Drug Code: " . $drug->kd_obat . "\n";
    echo "Drug Name: " . $drug->nm_obat . "\n";
    echo "Category: " . $drug->jenis . "\n";
    echo "Form: " . $drug->satuan . "\n";
    echo "Buy Price: Rp " . number_format($drug->harga_beli, 0, ',', '.') . "\n";
    echo "Sell Price: Rp " . number_format($drug->harga_jual, 0, ',', '.') . "\n";
    echo "Stock: " . $drug->stok . "\n";
    echo "Min Stock: " . $drug->min_stock_level . "\n";
    echo "Status: " . $drug->status . "\n";
    echo "Description: " . ($drug->description ?? 'NULL') . "\n";
    
    // NEW FIELDS CHECK
    echo "--- NEW FIELDS ---\n";
    echo "Expiry Date: " . ($drug->tanggal_kadaluarsa ?? 'NULL') . "\n";
    echo "Side Effects: " . ($drug->efek_samping ?? 'NULL') . "\n";
    echo "Contraindications: " . ($drug->kontraindikasi ?? 'NULL') . "\n";
    echo "Adult Dosage: " . ($drug->dosis_dewasa ?? 'NULL') . "\n";
    echo "Child Dosage: " . ($drug->dosis_anak ?? 'NULL') . "\n";
    echo "--- END NEW FIELDS ---\n";
    
    echo "Supplier: " . $drug->kd_supplier . "\n";
    echo "Created: " . $drug->created_at . "\n";
    echo "Updated: " . $drug->updated_at . "\n";
    echo str_repeat("=", 80) . "\n\n";
}

echo "=== SUMMARY ===\n";
echo "Total Drugs: " . $drugs->count() . "\n";
echo "Drugs with Expiry Date: " . $drugs->whereNotNull('tanggal_kadaluarsa')->count() . "\n";
echo "Drugs with Side Effects: " . $drugs->whereNotNull('efek_samping')->count() . "\n";
echo "Drugs with Contraindications: " . $drugs->whereNotNull('kontraindikasi')->count() . "\n";
echo "Drugs with Adult Dosage: " . $drugs->whereNotNull('dosis_dewasa')->count() . "\n";
echo "Drugs with Child Dosage: " . $drugs->whereNotNull('dosis_anak')->count() . "\n";
echo "=== END OF VERIFICATION ===\n";
