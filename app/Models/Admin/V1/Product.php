<?php

namespace App\Models\Admin\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'regular_price',
        'sale_price',
        'image',
        'images',
        'SKU',
        'featured',
        'quantity',
        'stock_status',
        'brand_id',
        'category_id',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

 public function brand(): BelongsTo
 {
     return $this->belongsTo(Brand::class,'brand_id');
 }
}
