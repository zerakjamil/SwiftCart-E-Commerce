<?php

namespace App\Models\Admin\V1;

use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slide extends Model
{
    use HasFactory, FillableAttributes;

    protected $fillable = [
        'image', 'tagline', 'title', 'subtitle', 'link'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('homepage_slides');
        });

        static::deleted(function () {
            Cache::forget('homepage_slides');
        });
    }
}
