<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'nota',
        'no_faktur',
        'kd_obat',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Attribute Accessors for Laravel-style property names
    public function getSaleIdAttribute()
    {
        return $this->nota;
    }

    public function setSaleIdAttribute($value)
    {
        $this->attributes['nota'] = $value;
    }

    public function getDrugIdAttribute()
    {
        return $this->kd_obat;
    }

    public function setDrugIdAttribute($value)
    {
        $this->attributes['kd_obat'] = $value;
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'nota', 'nota');
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class, 'kd_obat', 'kd_obat');
    }
}
