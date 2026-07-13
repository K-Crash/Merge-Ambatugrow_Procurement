<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['sku', 'name', 'category', 'price', 'unit'];

    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }
}
