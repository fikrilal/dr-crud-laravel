<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = 'nota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nota',
        'tgl_nota',
        'kd_pelanggan',
        'user_id',
        'diskon',
        'total_before_discount',
        'total_after_discount',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'tgl_nota' => 'datetime',
        'diskon' => 'decimal:2',
        'total_before_discount' => 'decimal:2',
        'total_after_discount' => 'decimal:2',
    ];

    // Attribute Accessors for Laravel-style property names
    public function getKodeTransaksiAttribute()
    {
        return $this->nota;
    }

    public function setKodeTransaksiAttribute($value)
    {
        $this->attributes['nota'] = $value;
    }

    public function getTanggalTransaksiAttribute()
    {
        return $this->tgl_nota;
    }

    public function setTanggalTransaksiAttribute($value)
    {
        $this->attributes['tgl_nota'] = $value;
    }

    public function getCustomerIdAttribute()
    {
        return $this->kd_pelanggan;
    }

    public function setCustomerIdAttribute($value)
    {
        $this->attributes['kd_pelanggan'] = $value;
    }

    public function getTotalHargaAttribute()
    {
        return $this->total_after_discount;
    }

    public function setTotalHargaAttribute($value)
    {
        $this->attributes['total_after_discount'] = $value;
        $this->attributes['total_before_discount'] = $value; // For now, no discount
    }

    public function getMetodePembayaranAttribute()
    {
        return $this->payment_method;
    }

    public function setMetodePembayaranAttribute($value)
    {
        $this->attributes['payment_method'] = $value;
    }

    public function getStatusAttribute()
    {
        return 'completed'; // Default status
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kd_pelanggan', 'kd_pelanggan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'nota', 'nota');
    }
}
