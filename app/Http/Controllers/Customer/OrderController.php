<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|string|exists:drugs,kd_obat',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $drug = Drug::where('kd_obat', $request->drug_id)->active()->first();
        
        if (!$drug || $drug->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->drug_id])) {
            $newQuantity = $cart[$request->drug_id]['quantity'] + $request->quantity;
            if ($newQuantity > $drug->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity exceeds available stock'
                ]);
            }
            $cart[$request->drug_id]['quantity'] = $newQuantity;
        } else {
            $cart[$request->drug_id] = [
                'drug_id' => $drug->kd_obat,
                'name' => $drug->nm_obat,
                'price' => $drug->harga_jual,
                'quantity' => $request->quantity,
                'form' => $drug->satuan,
                'max_stock' => $drug->stok
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('customer.cart.index', compact('cart', 'total'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->drug_id])) {
            $drug = Drug::where('kd_obat', $request->drug_id)->first();
            
            if ($request->quantity > $drug->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity exceeds available stock'
                ]);
            }

            $cart[$request->drug_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'total' => number_format($total, 0, ',', '.'),
                'item_total' => number_format($cart[$request->drug_id]['price'] * $cart[$request->drug_id]['quantity'], 0, ',', '.')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->drug_id])) {
            unset($cart[$request->drug_id]);
            session()->put('cart', $cart);

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'total' => number_format($total, 0, ',', '.')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('customer.catalog.index')
                ->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('customer.cart.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer'
        ]);

        // Map payment methods to database values
        $paymentMethod = $request->payment_method === 'cash_on_delivery' ? 'cash' : 'transfer';

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('customer.catalog.index')
                ->with('error', 'Your cart is empty');
        }

        try {
            DB::transaction(function () use ($request, $cart, $paymentMethod) {
                // Get customer record
                $customer = Customer::where('kd_pelanggan', auth()->user()->kd_pelanggan)->first();
                
                if (!$customer) {
                    throw new \Exception('Customer record not found');
                }

                // Calculate total
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                // Generate unique IDs
                $orderNumber = 'ONL-' . date('Ymd') . '-' . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
                
                // Prepare sale data (avoid metode_pembayaran due to mutator conflict)
                $saleData = [
                    'nota' => $orderNumber, // Primary key
                    'no_faktur' => $orderNumber, // Alternative order number
                    'tgl_nota' => now()->toDateString(), // Date only
                    'tanggal' => now(), // Full datetime
                    'kd_pelanggan' => $customer->kd_pelanggan,
                    'user_id' => 1, // System user for online orders
                    'diskon' => 0,
                    'total_before_discount' => $total,
                    'total_after_discount' => $total,
                    'payment_method' => $paymentMethod, // Mapped value: cash or transfer
                    'status_pembayaran' => 'pending',
                    'notes' => $request->notes,
                    'catatan' => $request->notes,
                    'alamat_kirim' => $request->delivery_address,
                    'status_pesanan' => 'pending',
                    'tipe_transaksi' => 'online'
                ];
                
                // Create sale record
                $sale = Sale::create($saleData);
                
                // Update metode_pembayaran directly to avoid mutator conflict
                DB::table('sales')
                    ->where('nota', $sale->nota)
                    ->update(['metode_pembayaran' => $request->payment_method]);

                // Create sale details and update stock
                foreach ($cart as $item) {
                    $drug = Drug::where('kd_obat', $item['drug_id'])->lockForUpdate()->first();
                    
                    if ($drug->stok < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$drug->nm_obat}");
                    }

                    SaleDetail::create([
                        'nota' => $sale->nota,
                        'no_faktur' => $sale->no_faktur,
                        'kd_obat' => $item['drug_id'],
                        'jumlah' => $item['quantity'],
                        'harga_satuan' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity']
                    ]);

                    // Update stock
                    $drug->decrement('stok', $item['quantity']);
                }

                // Clear cart
                session()->forget('cart');
            });

            return redirect()->route('customer.orders.index')
                ->with('success', 'Order placed successfully! We will contact you for payment confirmation.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function orders()
    {
        $customer = Customer::where('kd_pelanggan', auth()->user()->kd_pelanggan)->first();
        
        if (!$customer) {
            return view('customer.orders.index', ['orders' => collect()]);
        }

        $orders = Sale::with(['details.drug', 'customer'])
            ->where('kd_pelanggan', $customer->kd_pelanggan)
            ->where('tipe_transaksi', 'online')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $customer = Customer::where('kd_pelanggan', auth()->user()->kd_pelanggan)->first();
        
        $order = Sale::with(['details.drug', 'customer'])
            ->where('no_faktur', $id)
            ->where('kd_pelanggan', $customer->kd_pelanggan)
            ->where('tipe_transaksi', 'online')
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }
}
