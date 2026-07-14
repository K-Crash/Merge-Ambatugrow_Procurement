<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    use HasFactory;

    protected $table = 'units_of_measure';

    protected $fillable = ['uom_code', 'uom_name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'uom_id');
    }

    public function poItems()
    {
        return $this->hasMany(POItem::class, 'uom_id');
    }
}
