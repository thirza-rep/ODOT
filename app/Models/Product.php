<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'branch_id',
        'name',
        'sku',
        'description',
        'cost_price',
        'sell_price',
        'quantity',
        'min_stock',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'sell_price' => 'decimal:2',
            'quantity'   => 'integer',
            'min_stock'  => 'integer',
            'is_active'  => 'boolean',
        ];
    }

    // ──────────────── Relationships ────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ──────────────── Accessors (konversi ke Rupiah) ────────────────
    // Konvensi: 1 = Rp 1.000 | 0.5 = Rp 500 | 50 = Rp 50.000

    /**
     * Harga beli dalam Rupiah penuh.
     */
    public function getCostPriceRupiahAttribute(): float
    {
        return $this->cost_price * 1000;
    }

    /**
     * Harga jual dalam Rupiah penuh.
     */
    public function getSellPriceRupiahAttribute(): float
    {
        return $this->sell_price * 1000;
    }

    /**
     * Format harga jual: "Rp 50.000"
     */
    public function getFormattedSellPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->sell_price * 1000, 0, ',', '.');
    }

    /**
     * Format harga beli: "Rp 30.000"
     */
    public function getFormattedCostPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->cost_price * 1000, 0, ',', '.');
    }

    /**
     * Profit per unit dalam Rupiah.
     */
    public function getProfitPerUnitAttribute(): float
    {
        return ($this->sell_price - $this->cost_price) * 1000;
    }

    // ──────────────── Scopes ────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'min_stock');
    }

    public function scopeInBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeSearch($query, string $search)
    {
        $likeOperator = DB::connection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

        return $query->where(function ($q) use ($search, $likeOperator) {
            $q->where('name', $likeOperator, "%{$search}%")
              ->orWhere('sku', $likeOperator, "%{$search}%");
        });
    }

    // ──────────────── Helpers ────────────────

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock;
    }

    public static function generateSku(string $prefix = 'SKU'): string
    {
        do {
            $sku = $prefix . '-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }
}
