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
                $q->where('nama_obat', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%")
                  ->orWhere('bentuk_obat', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('nama_supplier', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
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
        $categories = Drug::distinct()->pluck('kategori')->filter();
        
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
        $drug = Drug::create($request->validated());

        return redirect()->route('drugs.index')
            ->with('success', 'Drug added successfully!');
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
        $drug->update($request->validated());

        return redirect()->route('drugs.index')
            ->with('success', 'Drug updated successfully!');
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

        $drugs = Drug::where('nama_obat', 'LIKE', "%{$query}%")
            ->where('stok', '>', 0)
            ->where('status', 'active')
            ->select('id', 'nama_obat', 'harga_jual', 'stok', 'bentuk_obat')
            ->limit(10)
            ->get();

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
