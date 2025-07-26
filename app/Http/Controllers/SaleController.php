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
                $q->where('kode_transaksi', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('nama_pelanggan', 'LIKE', "%{$search}%");
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
            $query->where('metode_pembayaran', $request->payment_method);
        }

        $sales = $query->paginate(15);
        $paymentMethods = Sale::distinct()->pluck('metode_pembayaran')->filter();
        
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
            DB::beginTransaction();

            // Generate transaction code
            $kodeTransaksi = 'TXN' . date('Ymd') . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create sale record
            $sale = Sale::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_transaksi' => now(),
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'total_harga' => 0, // Will be calculated
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'completed'
            ]);

            $totalHarga = 0;

            // Process each cart item
            foreach ($request->items as $item) {
                $drug = Drug::findOrFail($item['drug_id']);
                
                // Check stock availability
                if ($drug->stok < $item['jumlah']) {
                    throw new \Exception("Insufficient stock for {$drug->nama_obat}. Available: {$drug->stok}, Requested: {$item['jumlah']}");
                }

                $hargaSatuan = $drug->harga_jual;
                $subtotal = $hargaSatuan * $item['jumlah'];
                $totalHarga += $subtotal;

                // Create sale detail
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'drug_id' => $drug->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal
                ]);

                // Update drug stock
                $drug->decrement('stok', $item['jumlah']);
            }

            // Update sale total
            $sale->update(['total_harga' => $totalHarga]);

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
            $customer = Customer::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'nomor_telepon' => $request->nomor_telepon,
                'alamat' => $request->alamat ?? '',
                'tanggal_lahir' => null,
                'jenis_kelamin' => $request->jenis_kelamin ?? 'tidak_diketahui',
                'status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'nama_pelanggan' => $customer->nama_pelanggan,
                    'nomor_telepon' => $customer->nomor_telepon
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
            'today_sales' => Sale::whereDate('created_at', $today)->sum('total_harga'),
            'today_transactions' => Sale::whereDate('created_at', $today)->count(),
            'month_sales' => Sale::where('created_at', '>=', $thisMonth)->sum('total_harga'),
            'month_transactions' => Sale::where('created_at', '>=', $thisMonth)->count(),
            'recent_sales' => Sale::with(['customer', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($sale) {
                    return [
                        'id' => $sale->id,
                        'kode_transaksi' => $sale->kode_transaksi,
                        'customer_name' => $sale->customer->nama_pelanggan ?? 'Walk-in Customer',
                        'total_harga' => $sale->total_harga,
                        'created_at' => $sale->created_at->format('H:i'),
                        'pharmacist' => $sale->user->name
                    ];
                })
        ];

        return response()->json($stats);
    }
}
