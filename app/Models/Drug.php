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
        'tanggal_kadaluarsa',
        'efek_samping',
        'kontraindikasi',
        'dosis_dewasa',
        'dosis_anak',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'min_stock_level' => 'integer',
        'status' => 'string',
        'tanggal_kadaluarsa' => 'date',
    ];

    // Attribute Accessors for Laravel-style property names
    public function getNamaObatAttribute()
    {
        return $this->nm_obat;
    }

    public function setNamaObatAttribute($value)
    {
        $this->attributes['nm_obat'] = $value;
    }

    public function getKategoriAttribute()
    {
        return $this->jenis;
    }

    public function setKategoriAttribute($value)
    {
        $this->attributes['jenis'] = $value;
    }

    public function getBentukObatAttribute()
    {
        return $this->satuan;
    }

    public function setBentukObatAttribute($value)
    {
        $this->attributes['satuan'] = $value;
    }

    public function getSupplierIdAttribute()
    {
        return $this->kd_supplier;
    }

    public function setSupplierIdAttribute($value)
    {
        $this->attributes['kd_supplier'] = $value;
    }

    public function getStokMinimumAttribute()
    {
        return $this->min_stock_level;
    }

    public function setStokMinimumAttribute($value)
    {
        $this->attributes['min_stock_level'] = $value;
    }

    public function getDeskripsiAttribute()
    {
        return $this->description;
    }

    public function setDeskripsiAttribute($value)
    {
        $this->attributes['description'] = $value;
    }

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
