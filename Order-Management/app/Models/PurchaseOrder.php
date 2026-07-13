<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['po_number','supplier_id','requisition_id','status','total','expected_delivery','issued_at'];

    protected $casts = [
        'expected_delivery' => 'date',
        'issued_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}

