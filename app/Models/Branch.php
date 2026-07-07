<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ──────────────── Relationships ────────────────

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    // ──────────────── Scopes ────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ──────────────── Helpers ────────────────

    /**
     * Get a setting value for this branch, fallback to global.
     */
    public function getSetting(string $key, $default = null): ?string
    {
        $setting = $this->settings()->where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        // Fallback to global setting (branch_id = null)
        $global = Setting::whereNull('branch_id')->where('key', $key)->first();

        return $global?->value ?? $default;
    }
}
