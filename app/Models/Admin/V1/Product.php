<?php

namespace App\Models\Admin\V1;

use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory,FillableAttributes;

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



 protected function discountPercentage(): Attribute
{
    return Attribute::make(
        get: function ($value, $attributes) {
            if (!$this->sale_price || $this->regular_price <= 0) {
                return null;
            }
            $discount = (($this->regular_price - $this->sale_price) / $this->regular_price) * 100;
            return number_format($discount, 0);
        }
    );
}

    public function isOnSale(): bool
    {
        return $this->sale_price && $this->sale_price < $this->regular_price;
    }

    protected function images(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (is_array($value)) {
                    return $value;
                }
                return json_decode($value, true) ?? [];
            },
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

 public function brand(): BelongsTo
 {
     return $this->belongsTo(Brand::class,'brand_id');
 }
}
