<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street', 'city', 'province', 'zipcode', 'country'];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'address_id');
    }
}
