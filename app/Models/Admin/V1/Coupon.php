<?php

namespace App\Models\Admin\V1;

use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use FillableAttributes;

    protected $fillable = [
        'code',
        'discount',
        'expiry_date',
        'status',
    ];
    protected $casts = [
    'expiry_date' => 'datetime',
];
}
