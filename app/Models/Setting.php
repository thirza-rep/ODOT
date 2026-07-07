<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'key',
        'value',
        'group',
    ];

    // ──────────────── Relationships ────────────────

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // ──────────────── Helpers ────────────────

    /**
     * Get a setting value by key. Branch-specific first, then global fallback.
     */
    public static function getValue(string $key, ?int $branchId = null, $default = null): ?string
    {
        if ($branchId) {
            $setting = self::where('key', $key)->where('branch_id', $branchId)->first();
            if ($setting) return $setting->value;
        }

        // Fallback: global setting
        $global = self::where('key', $key)->whereNull('branch_id')->first();

        return $global?->value ?? $default;
    }

    /**
     * Set a setting value. Updates if exists, creates if not.
     */
    public static function setValue(string $key, string $value, ?int $branchId = null, string $group = 'general'): self
    {
        return self::updateOrCreate(
            ['key' => $key, 'branch_id' => $branchId],
            ['value' => $value, 'group' => $group]
        );
    }
}
