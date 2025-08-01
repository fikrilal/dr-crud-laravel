<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing the new drug code generation logic:\n";
echo "==========================================\n";

// Simulate the new logic
$lastDrug = App\Models\Drug::where('kd_obat', 'like', 'DR%')
                          ->orderBy('kd_obat', 'desc')
                          ->first();

$nextNumber = $lastDrug 
    ? (int)substr($lastDrug->kd_obat, 2) + 1 
    : 1;
$drugCode = 'DR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

echo "Last DR drug found: " . ($lastDrug ? $lastDrug->kd_obat . " - " . $lastDrug->nm_obat : "None") . "\n";
echo "Next number: $nextNumber\n";
echo "Generated code: $drugCode\n";

// Check if this code exists
$exists = App\Models\Drug::where('kd_obat', $drugCode)->exists();
echo "Does this code already exist? " . ($exists ? "YES - Still a problem!" : "NO - Good to go!") . "\n";

// Test the safety loop
$originalCode = $drugCode;
$safetyCounter = 0;
while (App\Models\Drug::where('kd_obat', $drugCode)->exists() && $safetyCounter < 10) {
    $nextNumber++;
    $drugCode = 'DR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    $safetyCounter++;
    echo "Safety loop iteration $safetyCounter: trying $drugCode\n";
}

if ($safetyCounter > 0) {
    echo "Final safe code after safety loop: $drugCode\n";
} else {
    echo "Original code $originalCode is safe to use!\n";
}
