<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedSupplier extends Model
{
    use HasFactory;

    protected $table = 'blacklisted_suppliers';

    protected $fillable = [
        'name', 'supplier_code', 'reason', 'blacklisted_since', 'risk_level',
    ];

    /**
     * Matches blacklisted.blade.php's expected "Jan. 12, 2026"-style string
     * via $b['since'].
     */
    public function getSinceAttribute(): string
    {
        return \Illuminate\Support\Carbon::parse($this->blacklisted_since)->format('M. d, Y');
    }

    public function getSupplierIdAttribute(): ?string
    {
        return $this->supplier_code;
    }
}
