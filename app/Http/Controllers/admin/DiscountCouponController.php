<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCouponController extends Controller
{
    public function index(Request $request) {
        $discountCoupons = DiscountCoupon::latest();
        if (!empty($request->get('keyword'))) {
            $discountCoupons = $discountCoupons->where('name','like','%'.$request->get('keyword').'%');
            $discountCoupons = $discountCoupons->orWhere('code','like','%'.$request->get('keyword').'%');
        }
        $discountCoupons = $discountCoupons->paginate(10);
        $data['discountCoupons'] = $discountCoupons;

        return view('admin.coupon.list', $data);
    }

    public function create() {
        return view('admin.coupon.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            // 'status' => 'required',
            // 'starts_at' => 'required',
            // 'expires_at' => 'required',
        ]);
        if ($validator->passes()) {

            // Starting date must be greater than current date
            if (!empty($request->starts_at)) {
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($startAt->lte($now) == true) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at' => 'Start date can not less than current date'],
                    ]);
                }
            }
            // Expires date must be greater than starting date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expireAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($expireAt->lte($startAt) == true) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expire date can not less than start date'],
                    ]);
                }
            }


            $discount_coupon = new DiscountCoupon();
            $discount_coupon->code = $request->code;
            $discount_coupon->name = $request->name;
            $discount_coupon->max_uses = $request->max_uses;
            $discount_coupon->max_uses_user = $request->max_uses_user;
            $discount_coupon->type = $request->type;
            $discount_coupon->discount_amount = $request->discount_amount;
            $discount_coupon->status = $request->status;
            $discount_coupon->starts_at = $request->starts_at;
            $discount_coupon->expires_at = $request->expires_at;
            $discount_coupon->save();
            session()->flash('success', 'Create discount coupon successfully');
            return response()->json([
                'status' => true,
                'message' =>'Create discount coupon successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id) {
        $discountCoupon = DiscountCoupon::find($id);
        if ($discountCoupon == null) {
            session()->flash('error', 'Discount coupon not found');
            return redirect()->route("coupons.index");
        }
        $data['discountCoupon'] = $discountCoupon;
        return view('admin.coupon.edit', $data);
    }

    public function update(Request $request, $id) {
        $discount_coupon = DiscountCoupon::find($id);
        if($discount_coupon == null) {
            session()->flash('error', 'Discount coupon not found');
            return response()->json([
                'status' => true
            ]);
        }
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'discount_amount' => 'required|numeric',
            // 'status' => 'required',
            // 'starts_at' => 'required',
            // 'expires_at' => 'required',
        ]);
        if ($validator->passes()) {

            // Starting date must be greater than current date
            if (!empty($request->starts_at)) {
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($startAt->lte($now) == true) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at' => 'Start date can not less than current date'],
                    ]);
                }
            }
            // Expires date must be greater than starting date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expireAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($expireAt->lte($startAt) == true) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expire date can not less than start date'],
                    ]);
                }
            }

            $discount_coupon->code = $request->code;
            $discount_coupon->name = $request->name;
            $discount_coupon->max_uses = $request->max_uses;
            $discount_coupon->max_uses_user = $request->max_uses_user;
            $discount_coupon->type = $request->type;
            $discount_coupon->discount_amount = $request->discount_amount;
            $discount_coupon->status = $request->status;
            $discount_coupon->starts_at = $request->starts_at;
            $discount_coupon->expires_at = $request->expires_at;
            $discount_coupon->save();
            session()->flash('success', 'Update discount coupon successfully');
            return response()->json([
                'status' => true,
                'message' =>'Update discount coupon successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id) {
        $discountCoupon = DiscountCoupon::find($id);
        if ($discountCoupon == null) {
            session()->flash('error', 'Discount coupon not found');
            return response()->json([
                'status' => true
            ]);
        }
        $discountCoupon->delete();
        session()->flash('success', 'Discount coupon deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Discount coupon deleted successfully',
        ]);
    }
}
