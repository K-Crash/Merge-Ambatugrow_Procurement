<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number', 'supplier_id', 'requisition_id', 'status', 'total', 'expected_delivery', 'issued_at',
        'payment_term_id', 'currency_id', 'order_date', 'created_by'
    ];

    protected $casts = [
        'expected_delivery' => 'date',
        'issued_at' => 'datetime',
        'total' => 'decimal:2',
        'order_date' => 'datetime',
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

    public function poItems()
    {
        return $this->hasMany(POItem::class, 'po_id');
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplierInvoices()
    {
        return $this->hasMany(SupplierInvoice::class, 'po_id');
    }
}

