<?php

namespace App\Models\Admin\V1;

use App\Models\UserCoupon;
use App\Traits\FillableAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use FillableAttributes, HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'expiry_date',
        'status',
    ];
    protected $casts = [
    'expiry_date' => 'datetime',
];

    public function userCoupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }

}
