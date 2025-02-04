<?php

namespace App\Models\Admin\V1;

use App\Models\Admin\V1\BaseModel;

class Brand extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];
}
