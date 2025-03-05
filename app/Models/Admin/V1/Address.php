<?php

namespace App\Models\Admin\V1;

use App\Models\User;
use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasOne};

class Address extends Model
{
    use HasFactory,FillableAttributes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
