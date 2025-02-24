<?php

namespace App\Models\Admin\V1;

use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory,FillableAttributes;

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
