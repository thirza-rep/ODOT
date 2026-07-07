<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'cost_price',
        'sell_price',
        'quantity',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'sell_price' => 'decimal:2',
            'quantity'   => 'integer',
            'subtotal'   => 'decimal:2',
        ];
    }

    // ──────────────── Relationships ────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ──────────────── Accessors (konversi ke Rupiah) ────────────────
    // Konvensi: 1 = Rp 1.000 | 0.5 = Rp 500

    public function getFormattedSellPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->sell_price * 1000, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal * 1000, 0, ',', '.');
    }

    /**
     * Profit per item line (dalam satuan ribuan).
     */
    public function getProfitAttribute(): float
    {
        return ($this->sell_price - $this->cost_price) * $this->quantity;
    }

    public function getFormattedProfitAttribute(): string
    {
        return 'Rp ' . number_format($this->profit * 1000, 0, ',', '.');
    }
}
