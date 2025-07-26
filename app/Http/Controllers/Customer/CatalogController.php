<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Drug::with('supplier')->active();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_obat', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('jenis', $request->category);
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('harga_jual', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('harga_jual', '<=', $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'name');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('harga_jual', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga_jual', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('nm_obat', 'asc');
        }

        $drugs = $query->whereRaw('stok > 0')->paginate(12);
        
        // Get unique categories for filter dropdown
        $categories = Drug::active()
            ->whereRaw('stok > 0')
            ->distinct()
            ->pluck('jenis')
            ->filter()
            ->sort();

        return view('customer.catalog.index', compact('drugs', 'categories'));
    }

    public function show($id)
    {
        $drug = Drug::with('supplier')->where('kd_obat', $id)->active()->firstOrFail();
        
        if ($drug->stok <= 0) {
            abort(404, 'Product not available');
        }

        // Get related drugs from same category
        $relatedDrugs = Drug::with('supplier')
            ->active()
            ->where('jenis', $drug->jenis)
            ->where('kd_obat', '!=', $drug->kd_obat)
            ->whereRaw('stok > 0')
            ->limit(4)
            ->get();

        return view('customer.catalog.show', compact('drug', 'relatedDrugs'));
    }
}
