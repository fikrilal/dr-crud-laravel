<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_pelanggan',
        'nm_pelanggan',
        'alamat',
        'kota',
        'telpon',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'string',
        'jenis_kelamin' => 'string',
    ];

    // Attribute Accessors for Laravel-style property names
    public function getNamaPelangganAttribute()
    {
        return $this->nm_pelanggan;
    }

    public function setNamaPelangganAttribute($value)
    {
        $this->attributes['nm_pelanggan'] = $value;
    }

    public function getNomorTeleponAttribute()
    {
        return $this->telpon;
    }

    public function setNomorTeleponAttribute($value)
    {
        $this->attributes['telpon'] = $value;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'kd_pelanggan', 'kd_pelanggan');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'kd_pelanggan', 'kd_pelanggan');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getGenderAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Male' : 'Female';
    }
}
