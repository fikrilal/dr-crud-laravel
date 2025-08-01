<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nm_supplier', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('kota', 'LIKE', "%{$search}%")
                  ->orWhere('telpon', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('kota', 'LIKE', "%{$request->city}%");
        }

        // Sort by name by default
        $query->orderBy('nm_supplier');

        $suppliers = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Supplier::count(),
            'active' => Supplier::where('status', 'active')->count(),
            'inactive' => Supplier::where('status', 'inactive')->count(),
            'cities' => Supplier::distinct('kota')->count('kota'),
        ];

        return view('suppliers.index', compact('suppliers', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            // Generate supplier code - improved logic to avoid duplicates
            $lastSupplier = Supplier::where('kd_supplier', 'like', 'SP%')
                ->orderByRaw('CAST(SUBSTRING(kd_supplier, 3) AS UNSIGNED) DESC')
                ->first();
            
            $nextNumber = $lastSupplier 
                ? (int)substr($lastSupplier->kd_supplier, 2) + 1 
                : 1;
            
            // Keep trying until we find a unique code
            do {
                $supplierCode = 'SP' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                $exists = Supplier::where('kd_supplier', $supplierCode)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            $supplier = Supplier::create([
                'kd_supplier' => $supplierCode,
                'nm_supplier' => $request->nama_supplier,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->nomor_telepon,
                'email' => $request->email,
                'contact_person' => $request->contact_person,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create supplier: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        // Get supplier statistics
        $stats = [
            'total_drugs' => $supplier->drugs()->count(),
            'active_drugs' => $supplier->drugs()->where('status', 'active')->count(),
            'total_purchases' => $supplier->purchases()->count(),
            'recent_purchases' => $supplier->purchases()->orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        return view('suppliers.show', compact('supplier', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            $supplier->update([
                'nm_supplier' => $request->nama_supplier,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->nomor_telepon,
                'email' => $request->email,
                'contact_person' => $request->contact_person,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update supplier: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            // Check if supplier has drugs or purchases
            if ($supplier->drugs()->count() > 0) {
                return back()->with('error', 'Cannot delete supplier that has drugs associated with it.');
            }

            if ($supplier->purchases()->count() > 0) {
                return back()->with('error', 'Cannot delete supplier that has purchase orders associated with it.');
            }

            $supplier->delete();
            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete supplier: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint for supplier search
     */
    public function search(Request $request)
    {
        $query = Supplier::where('status', 'active');
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nm_supplier', 'LIKE', "%{$search}%")
                  ->orWhere('kd_supplier', 'LIKE', "%{$search}%");
            });
        }

        $suppliers = $query->select('kd_supplier', 'nm_supplier', 'kota', 'telpon')
                          ->limit(10)
                          ->get();

        return response()->json($suppliers);
    }
}
