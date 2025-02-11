<?php

namespace App\Models\Admin\V1;

use App\Models\Admin\V1\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
