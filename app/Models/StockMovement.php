<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'branch_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity'        => 'integer',
            'quantity_before' => 'integer',
            'quantity_after'  => 'integer',
        ];
    }

    // ──────────────── Relationships ────────────────

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // ──────────────── Scopes ────────────────

    public function scopeIncoming($query)
    {
        return $query->where('type', 'in');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('type', 'out');
    }

    public function scopeAdjustment($query)
    {
        return $query->where('type', 'adjustment');
    }

    public function scopeInBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    // ──────────────── Helpers ────────────────

    /**
     * Create a stock movement and update product quantity.
     */
    public static function record(Product $product, int $userId, string $type, int $quantity, ?string $reference = null, ?string $notes = null, ?int $branchId = null): self
    {
        $quantityBefore = $product->quantity;

        // Calculate new quantity
        $quantityAfter = match ($type) {
            'in'         => $quantityBefore + abs($quantity),
            'out'        => $quantityBefore - abs($quantity),
            'adjustment' => $quantity, // absolute value
        };

        // Update product stock
        $product->update(['quantity' => $quantityAfter]);

        // Create movement record
        return self::create([
            'product_id'      => $product->id,
            'user_id'         => $userId,
            'branch_id'       => $branchId ?? $product->branch_id,
            'type'            => $type,
            'quantity'        => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after'  => $quantityAfter,
            'reference'       => $reference,
            'notes'           => $notes,
        ]);
    }

    // ──────────────── Accessors ────────────────

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'in'         => 'Barang Masuk',
            'out'        => 'Barang Keluar',
            'adjustment' => 'Penyesuaian',
            default      => $this->type,
        };
    }

    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type) {
            'in'         => 'bg-green-100 text-green-800',
            'out'        => 'bg-red-100 text-red-800',
            'adjustment' => 'bg-yellow-100 text-yellow-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }
}
