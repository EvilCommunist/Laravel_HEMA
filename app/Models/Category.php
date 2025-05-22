<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'cathegory';
    
    protected $fillable = ['name_of_type'];
    
    public function products()
    {
        return $this->hasMany(Good::class, 'cathegory');
    }
}
