<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Coupon;
use Illuminate\Support\Facades\{DB, Schema};

class CouponService
{
    public function createCoupon($data)
    {
        return DB::transaction(function () use ($data) {
            $coupon = new Coupon();
            $coupon->fillAttributes($data);
            $coupon->save();
            return $coupon;
        });
    }

    public function getPaginatedCoupons()
    {
        $query = Coupon::query();

        if (Schema::hasColumn('coupons', 'expiry_date')) {
            $query->orderBy('expiry_date', 'DESC');
        }

        return $query->paginate(10);
    }

    public function updateCoupon(Coupon $coupon, $data): void
    {
        DB::transaction(function () use ($coupon, $data) {
            $coupon->fillAttributes($data);
            $coupon->save();
        });
    }

    public function deleteCoupon(Coupon $coupon): void
    {
        DB::transaction(fn() => $coupon->delete());
    }
}
