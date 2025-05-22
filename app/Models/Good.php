<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'cathegory',
        'remain',
        'img_link',
        'name_of_prod',
        'description',
        'price'
    ];

    public function getImagesAttribute()
    {
        $imagesString = trim($this->img_link, '{}');
        return explode(',', $imagesString);
    }

    public function getMainImageAttribute()
    {
        $images = $this->images;
        return !empty($images) ? $images[0] : null;
    }

    public function characteristics()
    {
        return $this->hasMany(ProductCharacteristics::class, 'product_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'cathegory');
    }
}
