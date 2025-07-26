<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_supplier';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_supplier',
        'nm_supplier',
        'alamat',
        'kota',
        'telpon',
        'email',
        'contact_person',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Attribute Accessors for Laravel-style property names
    public function getNamaSupplierAttribute()
    {
        return $this->nm_supplier;
    }

    public function setNamaSupplierAttribute($value)
    {
        $this->attributes['nm_supplier'] = $value;
    }

    public function getNomorTeleponAttribute()
    {
        return $this->telpon;
    }

    public function setNomorTeleponAttribute($value)
    {
        $this->attributes['telpon'] = $value;
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class, 'kd_supplier', 'kd_supplier');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'kd_supplier', 'kd_supplier');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
