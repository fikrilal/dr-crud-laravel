<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey = 'nota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nota',
        'tgl_nota',
        'kd_supplier',
        'user_id',
        'diskon',
        'total_before_discount',
        'total_after_discount',
        'status',
        'notes'
    ];

    protected $casts = [
        'tgl_nota' => 'date',
        'diskon' => 'decimal:2',
        'total_before_discount' => 'decimal:2',
        'total_after_discount' => 'decimal:2',
    ];

    /**
     * Get the supplier that owns the purchase
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'kd_supplier', 'kd_supplier');
    }

    /**
     * Get the user who created the purchase
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchase details for the purchase
     */
    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class, 'nota', 'nota');
    }

    /**
     * Calculate total items in purchase
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->purchaseDetails->sum('jumlah');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'received' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('tgl_nota', [$from, $to]);
    }
}
