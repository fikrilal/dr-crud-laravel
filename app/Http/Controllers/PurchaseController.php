<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Drug;
use App\Models\Supplier;
use App\Http\Requests\StorePurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases with search and pagination
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'user', 'purchaseDetails.drug'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nota', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('nm_supplier', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('tgl_nota', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tgl_nota', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by supplier
        if ($request->filled('supplier')) {
            $query->where('kd_supplier', $request->supplier);
        }

        $purchases = $query->paginate(15);

        // Get suppliers for filter dropdown
        $suppliers = Supplier::where('status', 'active')
            ->orderBy('nm_supplier')
            ->get();

        return view('purchases.index', compact('purchases', 'suppliers'));
    }

    /**
     * Show the form for creating a new purchase
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')
            ->orderBy('nm_supplier')
            ->get();

        return view('purchases.create', compact('suppliers'));
    }

    /**
     * Store a newly created purchase in storage
     */
    public function store(StorePurchaseRequest $request)
    {
        try {
            Log::info('Purchase creation started', [
                'user_id' => Auth::id(),
                'supplier_id' => $request->kd_supplier,
                'items_count' => count($request->items ?? []),
                'items' => $request->items
            ]);

            DB::beginTransaction();

            // Generate purchase receipt number
            $receiptNumber = 'PO' . date('Ymd') . str_pad(Purchase::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create purchase record
            $purchase = Purchase::create([
                'nota' => $receiptNumber,
                'tgl_nota' => $request->tgl_nota,
                'kd_supplier' => $request->kd_supplier,
                'user_id' => Auth::id(),
                'total_before_discount' => 0, // Will be calculated
                'total_after_discount' => 0, // Will be calculated
                'diskon' => 0,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            $totalAmount = 0;

            // Create purchase detail records
            foreach ($request->items as $item) {
                $drug = Drug::where('kd_obat', $item['drug_id'])->first();
                
                if (!$drug) {
                    throw new \Exception("Drug with code {$item['drug_id']} not found");
                }

                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                $totalAmount += $subtotal;

                PurchaseDetail::create([
                    'nota' => $receiptNumber,
                    'kd_obat' => $item['drug_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal
                ]);

                Log::info('Purchase detail created', [
                    'nota' => $receiptNumber,
                    'drug_id' => $item['drug_id'],
                    'quantity' => $item['jumlah'],
                    'unit_price' => $item['harga_satuan'],
                    'subtotal' => $subtotal
                ]);
            }

            // Update purchase totals
            $purchase->update([
                'total_before_discount' => $totalAmount,
                'total_after_discount' => $totalAmount - $purchase->diskon
            ]);

            DB::commit();

            Log::info('Purchase created successfully', [
                'nota' => $receiptNumber,
                'total_amount' => $totalAmount,
                'supplier' => $request->kd_supplier
            ]);

            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('success', 'Purchase order created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Purchase creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified purchase
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'purchaseDetails.drug']);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified purchase
     */
    public function edit(Purchase $purchase)
    {
        // Only allow editing pending purchases
        if ($purchase->status !== 'pending') {
            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('error', 'Only pending purchases can be edited.');
        }

        $suppliers = Supplier::where('status', 'active')
            ->orderBy('nm_supplier')
            ->get();

        $purchase->load(['purchaseDetails.drug']);

        return view('purchases.edit', compact('purchase', 'suppliers'));
    }

    /**
     * Update the specified purchase in storage
     */
    public function update(StorePurchaseRequest $request, Purchase $purchase)
    {
        // Only allow updating pending purchases
        if ($purchase->status !== 'pending') {
            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('error', 'Only pending purchases can be updated.');
        }

        try {
            DB::beginTransaction();

            // Update purchase header
            $purchase->update([
                'tgl_nota' => $request->tgl_nota,
                'kd_supplier' => $request->kd_supplier,
                'notes' => $request->notes
            ]);

            // Delete existing details
            $purchase->purchaseDetails()->delete();

            $totalAmount = 0;

            // Create new purchase details
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                $totalAmount += $subtotal;

                PurchaseDetail::create([
                    'nota' => $purchase->nota,
                    'kd_obat' => $item['drug_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal
                ]);
            }

            // Update purchase totals
            $purchase->update([
                'total_before_discount' => $totalAmount,
                'total_after_discount' => $totalAmount - $purchase->diskon
            ]);

            DB::commit();

            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('success', 'Purchase order updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified purchase from storage
     */
    public function destroy(Purchase $purchase)
    {
        // Only allow deleting pending purchases
        if ($purchase->status !== 'pending') {
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Only pending purchases can be deleted.');
        }

        try {
            DB::beginTransaction();
            
            // Delete purchase details first (cascade will handle this, but explicit is better)
            $purchase->purchaseDetails()->delete();
            
            // Delete purchase
            $purchase->delete();
            
            DB::commit();

            return redirect()
                ->route('purchases.index')
                ->with('success', 'Purchase order deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Failed to delete purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Mark purchase as received and update drug stock
     */
    public function receive(Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('error', 'Only pending purchases can be received.');
        }

        try {
            DB::beginTransaction();

            // Update drug stock for each item
            foreach ($purchase->purchaseDetails as $detail) {
                $drug = $detail->drug;
                $drug->increment('stok', $detail->jumlah);
                
                Log::info('Drug stock updated', [
                    'drug_id' => $drug->kd_obat,
                    'previous_stock' => $drug->stok - $detail->jumlah,
                    'added_quantity' => $detail->jumlah,
                    'new_stock' => $drug->stok
                ]);
            }

            // Update purchase status
            $purchase->update(['status' => 'received']);

            DB::commit();

            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('success', 'Purchase order received successfully! Drug stock has been updated.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('error', 'Failed to receive purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a purchase order
     */
    public function cancel(Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()
                ->route('purchases.show', $purchase->nota)
                ->with('error', 'Only pending purchases can be cancelled.');
        }

        $purchase->update(['status' => 'cancelled']);

        return redirect()
            ->route('purchases.show', $purchase->nota)
            ->with('success', 'Purchase order cancelled successfully!');
    }
}
