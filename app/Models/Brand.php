<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function fillBrandData(array $data)
    {
        $this->name = $data['name'];
        $this->slug = Str::slug($data['slug']);
    }
}
