<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'invoice_number',
        'subtotal',
        'discount',
        'tax',
        'total',
        'amount_paid',
        'change_amount',
        'payment_method',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'      => 'decimal:2',
            'discount'      => 'decimal:2',
            'tax'           => 'decimal:2',
            'total'         => 'decimal:2',
            'amount_paid'   => 'decimal:2',
            'change_amount' => 'decimal:2',
        ];
    }

    // ──────────────── Relationships ────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ──────────────── Accessors (konversi ke Rupiah) ────────────────
    // Konvensi: 1 = Rp 1.000 | 0.5 = Rp 500 | 50 = Rp 50.000

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total * 1000, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal * 1000, 0, ',', '.');
    }

    public function getFormattedAmountPaidAttribute(): string
    {
        return 'Rp ' . number_format($this->amount_paid * 1000, 0, ',', '.');
    }

    public function getFormattedChangeAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->change_amount * 1000, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount * 1000, 0, ',', '.');
    }

    /**
     * Total profit kotor dari order ini (dalam satuan ribuan).
     */
    public function getGrossProfitAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->sell_price - $item->cost_price) * $item->quantity;
        });
    }

    public function getFormattedGrossProfitAttribute(): string
    {
        return 'Rp ' . number_format($this->gross_profit * 1000, 0, ',', '.');
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'     => 'Tunai',
            'transfer' => 'Transfer (Coming Soon)',
            'qris'     => 'QRIS (Coming Soon)',
            'ewallet'  => 'E-Wallet (Coming Soon)',
            default    => $this->payment_method,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending'   => 'bg-yellow-100 text-yellow-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default     => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'completed' => 'Selesai',
            'pending'   => 'Tertunda',
            'cancelled' => 'Dibatalkan',
            default     => $this->status,
        };
    }

    // ──────────────── Scopes ────────────────

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                     ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeInBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    // ──────────────── Helpers ────────────────

    /**
     * Generate a unique invoice number: INV-YYYYMMDD-XXXX
     */
    public static function generateInvoiceNumber(?int $branchId = null): string
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'INV-' . $date;

        $lastOrder = self::where('invoice_number', 'like', $prefix . '%')
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->orderByDesc('id')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
