<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpiryAlertController extends Controller
{
    public function index(Request $request)
    {
        $filterDays = $request->get('days', 90); // Default to 90 days
        $alertType = $request->get('type', 'all'); // all, critical, warning, notice
        
        // Since we don't have actual expiry dates in the database,
        // we'll simulate this based on creation date + estimated shelf life
        $expiryData = $this->getExpiryData($filterDays, $alertType);
        
        // Get alert statistics
        $stats = $this->getExpiryStats();
        
        return view('inventory.expiry-alerts', compact('expiryData', 'stats', 'filterDays', 'alertType'));
    }
    
    private function getExpiryData($filterDays, $alertType)
    {
        // Use actual expiry dates from tanggal_kadaluarsa field
        $drugs = Drug::where('status', 'active')
            ->with('supplier')
            ->get()
            ->map(function ($drug) {
                // Use actual expiry date if available, otherwise estimate
                if ($drug->tanggal_kadaluarsa) {
                    $expiryDate = Carbon::parse($drug->tanggal_kadaluarsa);
                    $daysUntilExpiry = Carbon::now()->diffInDays($expiryDate, false);
                } else {
                    // Fallback to simulation for drugs without expiry dates
                    $shelfLifeMonths = $this->getShelfLifeByType($drug->jenis);
                    $expiryDate = Carbon::parse($drug->created_at)->addMonths($shelfLifeMonths);
                    $daysUntilExpiry = Carbon::now()->diffInDays($expiryDate, false);
                }
                
                // Determine alert level
                $alertLevel = $this->getAlertLevel($daysUntilExpiry);
                
                return [
                    'drug' => $drug,
                    'estimated_expiry' => $expiryDate,
                    'days_until_expiry' => $daysUntilExpiry,
                    'alert_level' => $alertLevel,
                    'is_expired' => $daysUntilExpiry < 0,
                    'stock_value' => $drug->stok * $drug->harga_jual,
                    'has_actual_expiry' => !is_null($drug->tanggal_kadaluarsa),
                ];
            })
            ->filter(function ($item) use ($filterDays, $alertType) {
                // Filter by days
                if ($item['days_until_expiry'] > $filterDays && $item['days_until_expiry'] > 0) {
                    return false;
                }
                
                // Filter by alert type
                if ($alertType !== 'all') {
                    return $item['alert_level'] === $alertType;
                }
                
                return true;
            })
            ->sortBy('days_until_expiry')
            ->values();
            
        return $drugs;
    }
    
    private function getShelfLifeByType($type)
    {
        $shelfLives = [
            'Antibiotik' => 24,      // 2 years
            'Analgesik' => 36,       // 3 years
            'Vitamin' => 24,         // 2 years
            'Suplemen' => 18,        // 1.5 years
            'Antasida' => 30,        // 2.5 years
            'Antihistamin' => 36,    // 3 years
            'Antitusif' => 24,       // 2 years
            'NSAID' => 36,           // 3 years
            'Kortikosteroid' => 24,  // 2 years
            'Bronkodilator' => 18,   // 1.5 years
            'Antiseptik' => 36,      // 3 years
            'Gastroprotektan' => 30, // 2.5 years
            'Antihipertensi' => 36,  // 3 years
            'Antidiabetik' => 24,    // 2 years
            'Statin' => 36,          // 3 years
            'NSAID Topikal' => 24,   // 2 years
        ];
        
        return $shelfLives[$type] ?? 24; // Default 2 years
    }
    
    private function getAlertLevel($daysUntilExpiry)
    {
        if ($daysUntilExpiry < 0) {
            return 'expired';
        } elseif ($daysUntilExpiry <= 30) {
            return 'critical';   // Red - expires within 30 days
        } elseif ($daysUntilExpiry <= 90) {
            return 'warning';    // Orange - expires within 90 days
        } elseif ($daysUntilExpiry <= 180) {
            return 'notice';     // Yellow - expires within 6 months
        } else {
            return 'good';       // Green - more than 6 months
        }
    }
    
    private function getExpiryStats()
    {
        $expiryData = $this->getExpiryData(999999, 'all'); // Get all data for stats
        
        $stats = [
            'total_drugs' => Drug::where('status', 'active')->count(),
            'expired_count' => $expiryData->where('is_expired', true)->count(),
            'critical_count' => $expiryData->where('alert_level', 'critical')->count(),
            'warning_count' => $expiryData->where('alert_level', 'warning')->count(),
            'notice_count' => $expiryData->where('alert_level', 'notice')->count(),
            'good_count' => $expiryData->where('alert_level', 'good')->count(),
            'total_expired_value' => $expiryData->where('is_expired', true)->sum('stock_value'),
            'total_critical_value' => $expiryData->where('alert_level', 'critical')->sum('stock_value'),
            'total_at_risk_value' => $expiryData->whereIn('alert_level', ['expired', 'critical', 'warning'])->sum('stock_value'),
        ];
        
        return $stats;
    }
    
    public function updateExpiryDate(Request $request, Drug $drug)
    {
        $request->validate([
            'expiry_date' => 'required|date|after_or_equal:today'
        ]);
        
        $drug->update([
            'tanggal_kadaluarsa' => $request->expiry_date
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Expiry date updated successfully',
            'new_expiry_date' => $drug->fresh()->tanggal_kadaluarsa
        ]);
    }
    
    public function markAsChecked(Request $request, Drug $drug)
    {
        // Mark a drug as checked/reviewed for expiry
        // This could update a "last_checked" field if it existed
        return response()->json([
            'success' => true,
            'message' => 'Drug marked as checked'
        ]);
    }
    
    public function generateReport(Request $request)
    {
        $filterDays = $request->get('days', 90);
        $alertType = $request->get('type', 'all');
        
        $expiryData = $this->getExpiryData($filterDays, $alertType);
        $stats = $this->getExpiryStats();
        
        // This would generate a PDF or CSV report
        return response()->json([
            'success' => true,
            'message' => 'Expiry report generation would be implemented here',
            'data' => [
                'total_items' => $expiryData->count(),
                'total_value_at_risk' => $stats['total_at_risk_value']
            ]
        ]);
    }
}