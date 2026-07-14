<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Supplier;

class ContractHistory extends Model
{
    use HasFactory;

    protected $table = 'contract_histories';

    protected $fillable = [
        'supplier_id', 'date', 'action', 'performed_by', 'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
