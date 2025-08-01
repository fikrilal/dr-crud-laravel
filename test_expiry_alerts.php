<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Drug;
use Carbon\Carbon;

echo "=== TESTING EXPIRY ALERT FUNCTIONALITY ===\n\n";

try {
    // Create a drug that expires in 3 days
    $expiresSoon = Carbon::now()->addDays(3)->format('Y-m-d');
    
    // Create a drug that is already expired
    $alreadyExpired = Carbon::now()->subDays(5)->format('Y-m-d');
    
    // Create a drug that expires in 2 months (warning)
    $warningExpiry = Carbon::now()->addDays(60)->format('Y-m-d');
    
    $testDrugs = [
        [
            'kd_obat' => 'CRITICAL01',
            'nm_obat' => 'Critical Expiry Drug',
            'jenis' => 'Analgesik',
            'satuan' => 'Tablet',
            'harga_beli' => 1000,
            'harga_jual' => 1500,
            'stok' => 50,
            'min_stock_level' => 10,
            'kd_supplier' => 'SUP001',
            'status' => 'active',
            'description' => 'Drug expiring in 3 days',
            'tanggal_kadaluarsa' => $expiresSoon,
        ],
        [
            'kd_obat' => 'EXPIRED01',
            'nm_obat' => 'Expired Drug',
            'jenis' => 'Antibiotik',
            'satuan' => 'Kapsul',
            'harga_beli' => 2000,
            'harga_jual' => 3000,
            'stok' => 25,
            'min_stock_level' => 5,
            'kd_supplier' => 'SUP001',
            'status' => 'active',
            'description' => 'Drug that expired 5 days ago',
            'tanggal_kadaluarsa' => $alreadyExpired,
        ],
        [
            'kd_obat' => 'WARNING01',
            'nm_obat' => 'Warning Expiry Drug',
            'jenis' => 'Vitamin',
            'satuan' => 'Tablet',
            'harga_beli' => 500,
            'harga_jual' => 800,
            'stok' => 100,
            'min_stock_level' => 20,
            'kd_supplier' => 'SUP001',
            'status' => 'active',
            'description' => 'Drug expiring in 2 months',
            'tanggal_kadaluarsa' => $warningExpiry,
        ]
    ];
    
    echo "Creating test drugs with various expiry dates:\n\n";
    
    foreach ($testDrugs as $drugData) {
        $drug = Drug::create($drugData);
        echo "Created: {$drug->nm_obat} - Expires: {$drug->tanggal_kadaluarsa}\n";
    }
    
    echo "\n=== TESTING EXPIRY CONTROLLER LOGIC ===\n";
    
    // Test the updated controller logic
    $controller = new \App\Http\Controllers\ExpiryAlertController();
    
    // Use reflection to access private method for testing
    $reflectionClass = new ReflectionClass($controller);
    $getExpiryDataMethod = $reflectionClass->getMethod('getExpiryData');
    $getExpiryDataMethod->setAccessible(true);
    
    $expiryData = $getExpiryDataMethod->invoke($controller, 999, 'all');
    
    echo "\nExpiry Analysis Results:\n";
    echo "========================\n";
    
    foreach ($expiryData as $item) {
        $drug = $item['drug'];
        echo "Drug: {$drug->nm_obat}\n";
        echo "  Expiry Date: {$drug->tanggal_kadaluarsa}\n";
        echo "  Days Until Expiry: {$item['days_until_expiry']}\n";
        echo "  Alert Level: {$item['alert_level']}\n";
        echo "  Is Expired: " . ($item['is_expired'] ? 'YES' : 'NO') . "\n";
        echo "  Has Actual Expiry: " . ($item['has_actual_expiry'] ? 'YES' : 'NO') . "\n";
        echo "  Stock Value: Rp " . number_format($item['stock_value'], 0, ',', '.') . "\n";
        echo "  ----------------\n";
    }
    
    // Clean up test drugs
    Drug::whereIn('kd_obat', ['CRITICAL01', 'EXPIRED01', 'WARNING01'])->delete();
    echo "\nTest drugs deleted.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== END OF EXPIRY TEST ===\n";
