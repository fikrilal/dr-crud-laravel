<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_obat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_obat',
        'nm_obat',
        'jenis',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'kd_supplier',
        'status',
        'min_stock_level',
        'description',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'min_stock_level' => 'integer',
        'status' => 'string',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kd_supplier', 'kd_supplier');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'kd_obat', 'kd_obat');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'kd_obat', 'kd_obat');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stok <= min_stock_level');
    }

    public function isLowStock()
    {
        return $this->stok <= $this->min_stock_level;
    }
}
