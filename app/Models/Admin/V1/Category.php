<?php

namespace App\Models\Admin\V1;

use App\Models\Admin\V1\BaseModel;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
