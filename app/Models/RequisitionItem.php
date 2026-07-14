<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    protected $fillable = [
        'requisition_id', 'service_id', 'name', 'qty', 'unit', 'unit_price', 'total',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
