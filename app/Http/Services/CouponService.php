<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Coupon;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\{Auth, DB, Schema, Session};
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CouponService
{
    private $discountService;

    public function __construct(DiscountService $discountService = null)
    {
        $this->discountService = $discountService ?? new DiscountService();
    }

    public function getPaginatedCoupons()
    {
        $query = Coupon::query();

        if (Schema::hasColumn('coupons', 'expiry_date')) {
            $query->orderBy('expiry_date', 'DESC');
        }

        return $query->paginate(10);
    }

    public function createCoupon($data)
    {
        return DB::transaction(function () use ($data) {
            $coupon = new Coupon();
            $coupon->fillAttributes($data);
            $coupon->save();
            return $coupon;
        });
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

    public function getCouponByCode($code)
    {
        return Coupon::where('code', $code)
            ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
            ->first();
    }

    public function applyCoupon(string $couponCode): array
    {
        if (!Auth::check()) {
            return ['success' => false, 'message' => 'Please login to apply a coupon'];
        }

        if (empty($couponCode)) {
            return ['success' => false, 'message' => 'Please enter a coupon code'];
        }

        $coupon = $this->getCouponByCode($couponCode);

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon'];
        }

        $userId = Auth::id();

        // Deactivate the currently active coupon, if any
        $this->deactivateCurrentCoupon($userId);

        $userCoupon = UserCoupon::where('user_id', $userId)
            ->where('coupon_id', $coupon->id)
            ->first();

        if ($userCoupon) {
            $userCoupon->update(['is_active' => true]);
        } else {
            $this->recordCouponUsage($userId, $coupon->id);
        }

        $this->storeCouponInSession($coupon);
        $this->discountService->calculateDiscount();

        return ['success' => true, 'message' => 'Coupon applied successfully'];
    }

    private function deactivateCurrentCoupon($userId): void
    {
        UserCoupon::where('user_id', $userId)
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }

    private function recordCouponUsage($userId, $couponId): void
    {
        UserCoupon::create([
            'user_id' => $userId,
            'coupon_id' => $couponId,
            'used_at' => now(),
            'is_active' => true,
        ]);
    }

    private function storeCouponInSession($coupon): void
    {
        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);
    }

    public function removeCoupon(): array
    {
        if (!Auth::check()) {
            return ['success' => false, 'message' => 'Please login to remove a coupon'];
        }

        $userId = Auth::id();
        $this->deactivateCurrentCoupon($userId);
        Session::forget('coupon');
        $this->discountService->removeDiscount();

        return ['success' => true, 'message' => 'Coupon removed successfully'];
    }

    public function getCurrentCoupon()
    {
        if (!Auth::check()) {
            return null;
        }

        $userId = Auth::id();
        return UserCoupon::where('user_id', $userId)
            ->where('is_active', true)
            ->with('coupon')
            ->first();
    }
}
