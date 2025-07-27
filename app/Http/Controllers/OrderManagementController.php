<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['details.drug', 'customer', 'user'])
            ->where('tipe_transaksi', 'online');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_pesanan', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('status_pembayaran', $request->payment_status);
        }

        // Search by order number or customer
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_faktur', 'like', "%{$search}%")
                  ->orWhere('nota', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('nm_pelanggan', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Sale::with(['details.drug', 'customer', 'user'])
            ->where('no_faktur', $id)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:pending,processing,shipped,completed,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $order = Sale::where('no_faktur', $id)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        // Check if we're cancelling and need to restore stock
        if ($request->status_pesanan === 'cancelled' && $order->status_pesanan !== 'cancelled') {
            DB::transaction(function () use ($order) {
                foreach ($order->details as $detail) {
                    $drug = Drug::where('kd_obat', $detail->kd_obat)->first();
                    if ($drug) {
                        $drug->increment('stok', $detail->jumlah);
                    }
                }
            });
        }

        $order->update([
            'status_pesanan' => $request->status_pesanan,
            'catatan' => $request->notes ? $order->catatan . "\n\nAdmin Note: " . $request->notes : $order->catatan
        ]);

        return back()->with('success', 'Order status updated successfully');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,paid,failed,refunded'
        ]);

        $order = Sale::where('no_faktur', $id)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        $order->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('success', 'Payment status updated successfully');
    }

    public function confirm($id)
    {
        $order = Sale::where('no_faktur', $id)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        if ($order->status_pesanan !== 'pending') {
            return back()->with('error', 'Order has already been processed');
        }

        // Check stock availability before confirming
        foreach ($order->details as $detail) {
            $drug = Drug::where('kd_obat', $detail->kd_obat)->first();
            if (!$drug) {
                return back()->with('error', "Drug with code {$detail->kd_obat} not found");
            }
            if ($drug->stok < $detail->jumlah) {
                return back()->with('error', "Insufficient stock for {$drug->nm_obat}");
            }
        }

        $order->update([
            'status_pesanan' => 'processing',
            'catatan' => $order->catatan . "\n\nConfirmed by: " . auth()->user()->name . " at " . now()->format('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Order confirmed and moved to processing');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $order = Sale::where('no_faktur', $id)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        if ($order->status_pesanan !== 'pending') {
            return back()->with('error', 'Order has already been processed');
        }

        DB::transaction(function () use ($order, $request) {
            // Restore stock
            foreach ($order->details as $detail) {
                $drug = Drug::where('kd_obat', $detail->kd_obat)->first();
                if ($drug) {
                    $drug->increment('stok', $detail->jumlah);
                }
            }

            // Update order status
            $order->update([
                'status_pesanan' => 'cancelled',
                'catatan' => $order->catatan . "\n\nRejected by: " . auth()->user()->name . 
                           "\nReason: " . $request->reason . 
                           "\nDate: " . now()->format('Y-m-d H:i:s')
            ]);
        });

        return back()->with('success', 'Order rejected and stock restored');
    }
}
