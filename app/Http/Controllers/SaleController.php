<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Drug;
use App\Models\Customer;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of sales with search and pagination
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'saleDetails.drug'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nota', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('nm_pelanggan', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->paginate(15);
        $paymentMethods = Sale::distinct()->pluck('payment_method')->filter();
        
        return view('sales.index', compact('sales', 'paymentMethods'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('sales.create', compact('customers'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        try {
            // Add detailed logging for debugging
            Log::info('Sale creation started', [
                'user_id' => Auth::id(),
                'customer_id' => $request->customer_id,
                'payment_method' => $request->metode_pembayaran,
                'items_count' => count($request->items ?? []),
                'items' => $request->items
            ]);

            DB::beginTransaction();

            // Generate transaction code
            $kodeTransaksi = 'TXN' . date('Ymd') . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create sale record
            $sale = Sale::create([
                'nota' => $kodeTransaksi,
                'tgl_nota' => now(),
                'kd_pelanggan' => $request->customer_id,
                'user_id' => Auth::id(),
                'total_before_discount' => 0, // Will be calculated
                'total_after_discount' => 0, // Will be calculated
                'payment_method' => $request->metode_pembayaran,
                'diskon' => 0
            ]);

            $totalHarga = 0;

            // Process each cart item
            foreach ($request->items as $item) {
                $drug = Drug::where('kd_obat', $item['drug_id'])->firstOrFail();
                
                // Check stock availability
                if ($drug->stok < $item['jumlah']) {
                    throw new \Exception("Insufficient stock for {$drug->nm_obat}. Available: {$drug->stok}, Requested: {$item['jumlah']}");
                }

                $hargaSatuan = $drug->harga_jual;
                $subtotal = $hargaSatuan * $item['jumlah'];
                $totalHarga += $subtotal;

                // Create sale detail
                SaleDetail::create([
                    'nota' => $sale->nota,
                    'kd_obat' => $drug->kd_obat,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal
                ]);

                // Update drug stock
                $drug->decrement('stok', $item['jumlah']);
            }

            // Update sale total
            $sale->update([
                'total_before_discount' => $totalHarga,
                'total_after_discount' => $totalHarga
            ]);

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Sale failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified sale with receipt view.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'user', 'saleDetails.drug']);
        return view('sales.show', compact('sale'));
    }

    /**
     * API endpoint for getting drug information during sale
     */
    public function getDrug(Request $request): JsonResponse
    {
        $drugId = $request->get('drug_id');
        
        if (!$drugId) {
            return response()->json(['error' => 'Drug ID required'], 400);
        }

        $drug = Drug::where('id', $drugId)
            ->where('status', 'active')
            ->where('stok', '>', 0)
            ->first();

        if (!$drug) {
            return response()->json(['error' => 'Drug not found or out of stock'], 404);
        }

        return response()->json([
            'id' => $drug->id,
            'nama_obat' => $drug->nama_obat,
            'harga_jual' => $drug->harga_jual,
            'stok' => $drug->stok,
            'bentuk_obat' => $drug->bentuk_obat
        ]);
    }

    /**
     * API endpoint for creating quick customer during sale
     */
    public function createQuickCustomer(Request $request): JsonResponse
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20'
        ]);

        try {
            // Generate customer ID
            $customerId = 'C' . date('Ymd') . str_pad(Customer::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);
            
            $customer = Customer::create([
                'kd_pelanggan' => $customerId,
                'nm_pelanggan' => $request->nama_pelanggan,
                'telpon' => $request->nomor_telepon,
                'alamat' => $request->alamat ?? '',
                'tanggal_lahir' => null,
                'jenis_kelamin' => $request->jenis_kelamin ?? 'L',
                'status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->kd_pelanggan,
                    'nama_pelanggan' => $customer->nm_pelanggan,
                    'nomor_telepon' => $customer->telpon
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create customer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate receipt for printing
     */
    public function receipt(Sale $sale)
    {
        $sale->load(['customer', 'user', 'saleDetails.drug']);
        return view('sales.receipt', compact('sale'));
    }

    /**
     * Get sales statistics for dashboard
     */
    public function getStats(Request $request): JsonResponse
    {
        $today = today();
        $thisMonth = now()->startOfMonth();

        $stats = [
            'today_sales' => Sale::whereDate('created_at', $today)->sum('total_after_discount'),
            'today_transactions' => Sale::whereDate('created_at', $today)->count(),
            'month_sales' => Sale::where('created_at', '>=', $thisMonth)->sum('total_after_discount'),
            'month_transactions' => Sale::where('created_at', '>=', $thisMonth)->count(),
            'recent_sales' => Sale::with(['customer', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($sale) {
                    return [
                        'id' => $sale->nota,
                        'kode_transaksi' => $sale->nota,
                        'customer_name' => $sale->customer->nm_pelanggan ?? 'Walk-in Customer',
                        'total_harga' => $sale->total_after_discount,
                        'created_at' => $sale->created_at->format('H:i'),
                        'pharmacist' => $sale->user->name
                    ];
                })
        ];

        return response()->json($stats);
    }
}
