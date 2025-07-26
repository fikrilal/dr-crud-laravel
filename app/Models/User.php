<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'kd_pelanggan',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'user_type' => 'string',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kd_pelanggan', 'kd_pelanggan');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id', 'id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('user_type', $type);
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isPharmacist()
    {
        return $this->user_type === 'pharmacist';
    }

    public function isCustomer()
    {
        return $this->user_type === 'customer';
    }
}
