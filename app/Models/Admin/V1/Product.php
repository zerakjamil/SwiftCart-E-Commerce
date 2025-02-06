<?php

namespace App\Models\Admin\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
