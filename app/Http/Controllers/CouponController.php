<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\CouponRequests\StoreCouponRequest;
use App\Models\Admin\V1\Coupon;
use Illuminate\Support\Facades\{DB,Log};

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(10);
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(StoreCouponRequest $request)
    {
        try {
            DB::beginTransaction();

            $coupon = new Coupon();
            $coupon->fillAttributes($request->validated());
            $coupon->save();

            DB::commit();
            return redirect()->route('coupon.index')->withSuccess('Coupon geberated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create Coupon. Please try again.');
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            DB::beginTransaction();
            $coupon->delete();
            DB::commit();
            return redirect()->route('coupon.index')->withSuccess('status','Coupon deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon deletion failed: ' . $e->getMessage());
            return back()->withError('status','Failed to delete Coupon. Please try again.');
        }
    }
}
