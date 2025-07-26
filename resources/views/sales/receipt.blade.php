<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $sale->kode_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            width: 302px; /* 80mm thermal printer width */
            margin: 0 auto;
            padding: 10px;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .pharmacy-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .pharmacy-info {
            font-size: 10px;
            margin-bottom: 1px;
        }
        
        .receipt-details {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .items-header {
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .item-row {
            margin-bottom: 5px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 2px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 1px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        
        .item-qty-price {
            display: flex;
            justify-content: space-between;
            margin-top: 1px;
        }
        
        .receipt-totals {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-bottom: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 3px;
        }
        
        .receipt-footer {
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .thank-you {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 5px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Receipt</button>
    
    <div class="receipt">
        <!-- Header -->
        <div class="receipt-header">
            <div class="pharmacy-name">{{ config('app.name', 'Dr. CRUD') }}</div>
            <div class="pharmacy-info">Pharmacy Management System</div>
            <div class="pharmacy-info">Professional Healthcare Solutions</div>
            <div class="pharmacy-info">Tel: (555) 123-4567</div>
            <div class="pharmacy-info">Email: info@pharmacy.com</div>
        </div>
        
        <!-- Transaction Details -->
        <div class="receipt-details">
            <div class="detail-row">
                <span>Receipt No:</span>
                <span>{{ $sale->kode_transaksi }}</span>
            </div>
            <div class="detail-row">
                <span>Date:</span>
                <span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span>Pharmacist:</span>
                <span>{{ $sale->user->name }}</span>
            </div>
            @if($sale->customer)
                <div class="detail-row">
                    <span>Customer:</span>
                    <span>{{ $sale->customer->nama_pelanggan }}</span>
                </div>
                @if($sale->customer->nomor_telepon)
                    <div class="detail-row">
                        <span>Phone:</span>
                        <span>{{ $sale->customer->nomor_telepon }}</span>
                    </div>
                @endif
            @else
                <div class="detail-row">
                    <span>Customer:</span>
                    <span>Walk-in Customer</span>
                </div>
            @endif
            <div class="detail-row">
                <span>Payment:</span>
                <span>{{ ucfirst(str_replace('_', ' ', $sale->metode_pembayaran)) }}</span>
            </div>
        </div>
        
        <!-- Items -->
        <div class="items-table">
            <div class="items-header">
                ITEMS PURCHASED
            </div>
            
            @foreach($sale->saleDetails as $detail)
                <div class="item-row">
                    <div class="item-name">{{ $detail->drug->nama_obat }}</div>
                    <div class="item-details">
                        <span>{{ $detail->drug->bentuk_obat }}</span>
                        <span>{{ $detail->drug->kategori }}</span>
                    </div>
                    <div class="item-qty-price">
                        <span>{{ $detail->jumlah }} x ${{ number_format($detail->harga_satuan, 2) }}</span>
                        <span>${{ number_format($detail->subtotal, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Totals -->
        <div class="receipt-totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($sale->total_harga, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax (0%):</span>
                <span>$0.00</span>
            </div>
            <div class="total-row">
                <span>Discount:</span>
                <span>$0.00</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>${{ number_format($sale->total_harga, 2) }}</span>
            </div>
        </div>
        
        <!-- Summary -->
        <div class="receipt-details">
            <div class="detail-row">
                <span>Total Items:</span>
                <span>{{ $sale->saleDetails->sum('jumlah') }}</span>
            </div>
            <div class="detail-row">
                <span>Unique Drugs:</span>
                <span>{{ $sale->saleDetails->count() }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="receipt-footer">
            <div class="thank-you">THANK YOU FOR YOUR PURCHASE!</div>
            <div>Please keep this receipt for your records</div>
            <div>Return Policy: 7 days with receipt</div>
            <div>For inquiries: support@pharmacy.com</div>
            <br>
            <div>{{ now()->format('d/m/Y H:i:s') }}</div>
            <div>Powered by Dr. CRUD Pharmacy System</div>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
        
        // Print function
        function printReceipt() {
            window.print();
        }
        
        // Focus on print button for accessibility
        document.querySelector('.print-button').focus();
    </script>
</body>
</html> 