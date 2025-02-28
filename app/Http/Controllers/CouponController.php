<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\CouponRequests\StoreCouponRequest;
use App\Http\Services\CouponService;
use App\Models\Admin\V1\Coupon;
use Illuminate\Support\Facades\{DB,Log};

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $coupons = $this->couponService->getPaginatedCoupons();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('admin.coupon.create');
    }

    public function store(StoreCouponRequest $request)
    {
        try {
            $this->couponService->createCoupon($request->validated());
            return redirect()->route('coupon.index')->withSuccess('Coupon generated successfully.');
        } catch (\Exception $e) {
            Log::error('Coupon creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withError(__('coupon.creation_failed'))
                ->instance($request->validated());
        }
    }

    public function edit(Coupon $coupon): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(StoreCouponRequest $request, Coupon $coupon)
    {
        try {
            $this->couponService->updateCoupon($coupon, $request->validated());
            return redirect()->route('coupon.index')->withSuccess('Coupon updated successfully.');
        } catch (\Exception $e) {
            Log::error('Coupon updation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withError(__('coupon.updation_failed'))
                ->instance($request->validated());
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $this->couponService->deleteCoupon($coupon);
            return redirect()->route('coupon.index')->withSuccess('Coupon deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete Coupon. Please try again.');
        }
    }
}
