<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCharacteristics extends Model
{
    protected $fillable = [
        'product_id',
        'characteristic'
    ];
    
    public function product()
    {
        return $this->belongsTo(Good::class);
    }
}
