<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Drug code analysis:\n";
echo "==================\n";

$totalDrugs = App\Models\Drug::count();
$drCodes = App\Models\Drug::where('kd_obat', 'like', 'DR%')->count();
$obtCodes = App\Models\Drug::where('kd_obat', 'like', 'OBT%')->count();

echo "Total drugs: $totalDrugs\n";
echo "DR codes: $drCodes\n";
echo "OBT codes: $obtCodes\n\n";

echo "All DR codes in database:\n";
$drDrugs = App\Models\Drug::where('kd_obat', 'like', 'DR%')->orderBy('kd_obat')->get();
foreach ($drDrugs as $drug) {
    echo $drug->kd_obat . " - " . $drug->nm_obat . "\n";
}

echo "\nLast few OBT codes:\n";
$obtDrugs = App\Models\Drug::where('kd_obat', 'like', 'OBT%')->orderBy('kd_obat', 'desc')->take(5)->get();
foreach ($obtDrugs as $drug) {
    echo $drug->kd_obat . " - " . $drug->nm_obat . "\n";
}

// Check what the next DR code should be
$lastDrDrug = App\Models\Drug::where('kd_obat', 'like', 'DR%')->orderBy('kd_obat', 'desc')->first();
if ($lastDrDrug) {
    $nextNumber = (int)substr($lastDrDrug->kd_obat, 2) + 1;
    $nextCode = 'DR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    echo "\nLast DR code: " . $lastDrDrug->kd_obat . "\n";
    echo "Next DR code should be: " . $nextCode . "\n";
} else {
    echo "\nNo DR codes found, next should be: DR0001\n";
}
