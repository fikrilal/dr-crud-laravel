<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'nota',
        'kd_obat',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the purchase that owns the detail
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'nota', 'nota');
    }

    /**
     * Get the drug for this detail
     */
    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'kd_obat', 'kd_obat');
    }

    /**
     * Calculate subtotal automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->subtotal = $model->jumlah * $model->harga_satuan;
        });
    }
}
