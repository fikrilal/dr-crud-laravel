<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Supplier;
use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource with search and pagination
     */
    public function index(Request $request)
    {
        $query = Drug::with('supplier');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nm_obat', 'LIKE', "%{$search}%")
                  ->orWhere('jenis', 'LIKE', "%{$search}%")
                  ->orWhere('satuan', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('nm_supplier', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('jenis', $request->category);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('stok', '<=', 10);
            } elseif ($request->stock_status === 'out') {
                $query->where('stok', 0);
            }
        }

        $drugs = $query->latest()->paginate(15);
        $categories = Drug::distinct()->pluck('jenis')->filter();
        
        return view('drugs.index', compact('drugs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->get();
        return view('drugs.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDrugRequest $request)
    {
        try {
            // Generate drug code
            $lastDrug = Drug::orderBy('kd_obat', 'desc')->first();
            $nextNumber = $lastDrug 
                ? (int)substr($lastDrug->kd_obat, 2) + 1 
                : 1;
            $drugCode = 'DR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $drug = Drug::create([
                'kd_obat' => $drugCode,
                'nm_obat' => $request->nama_obat,
                'jenis' => $request->kategori,
                'satuan' => $request->bentuk_obat,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'min_stock_level' => $request->stok_minimum,
                'kd_supplier' => $request->supplier_id,
                'status' => $request->status,
                'description' => $request->deskripsi,
            ]);

            return redirect()->route('drugs.index')
                ->with('success', 'Drug added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add drug: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Drug $drug)
    {
        $drug->load('supplier');
        return view('drugs.show', compact('drug'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drug $drug)
    {
        $suppliers = Supplier::where('status', 'active')->get();
        return view('drugs.edit', compact('drug', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        try {
            $drug->update([
                'nm_obat' => $request->nama_obat,
                'jenis' => $request->kategori,
                'satuan' => $request->bentuk_obat,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'min_stock_level' => $request->stok_minimum,
                'kd_supplier' => $request->supplier_id,
                'status' => $request->status,
                'description' => $request->deskripsi,
            ]);

            return redirect()->route('drugs.index')
                ->with('success', 'Drug updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update drug: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug)
    {
        try {
            $drug->delete();
            return redirect()->route('drugs.index')
                ->with('success', 'Drug deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('drugs.index')
                ->with('error', 'Cannot delete drug. It may be referenced in sales records.');
        }
    }

    /**
     * API endpoint for real-time drug search (for sales)
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $drugs = Drug::where('nm_obat', 'LIKE', "%{$query}%")
            ->where('stok', '>', 0)
            ->where('status', 'active')
            ->select('kd_obat', 'nm_obat', 'harga_jual', 'stok', 'satuan')
            ->limit(10)
            ->get()
            ->map(function($drug) {
                return [
                    'id' => $drug->kd_obat,
                    'nama_obat' => $drug->nm_obat,
                    'harga_jual' => $drug->harga_jual,
                    'stok' => $drug->stok,
                    'bentuk_obat' => $drug->satuan
                ];
            });

        return response()->json($drugs);
    }

    /**
     * Update drug stock
     */
    public function updateStock(Request $request, Drug $drug)
    {
        $request->validate([
            'stock_change' => 'required|integer',
            'type' => 'required|in:add,subtract',
            'reason' => 'required|string|max:255'
        ]);

        $stockChange = $request->stock_change;
        if ($request->type === 'subtract') {
            $stockChange = -$stockChange;
        }

        $newStock = $drug->stok + $stockChange;
        
        if ($newStock < 0) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $drug->update(['stok' => $newStock]);

        return back()->with('success', "Stock updated successfully. New stock: {$newStock}");
    }
}
