<?php

namespace App\Models\Admin\V1;

use App\Models\User;
use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

class Address extends Model
{
    use HasFactory,FillableAttributes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
