<?php

namespace App\Models\Admin\V1;

use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory,FillableAttributes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
