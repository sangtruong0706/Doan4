<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create () {
        $provinces = Province::get();
        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'provinces.name')->
        leftJoin('provinces','provinces.id','shipping_charges.province_id');
        $shippingCharges = $shippingCharges->paginate(10);
        $data['provinces'] = $provinces;
        $data['shippingCharges'] = $shippingCharges;
        return view('admin.shipping.create', $data);
    }
    public function store ( Request $request) {
        $validator = Validator::make($request->all(), [
            'province' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $count = ShippingCharge::where('province_id', $request->province)->count();
        if ($count > 0) {
            session()->flash('error', 'ShippingCharge is exited');
            return response()->json([
                'status' => true,
                'message' => 'ShippingCharge is exited',
            ]);
        }
        $shipping = new ShippingCharge();
        $shipping->province_id = $request->province;
        $shipping->amount = $request->amount;
        $shipping->save();
        session()->flash('success', 'Create ShippingCharge successfully');
        return response()->json([
            'status' => true,
            'message' => 'Create ShippingCharge successfully',
        ]);
    }

    public function edit($id) {
        $provinces = Province::get();
        $shippingCharge = ShippingCharge::find($id);
        $data['provinces'] = $provinces;
        $data['shippingCharge'] = $shippingCharge;
        return view('admin.shipping.edit', $data);
    }

    public function update ( Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'province' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $shipping =  ShippingCharge::find($id);
        $shipping->province_id = $request->province;
        $shipping->amount = $request->amount;
        $shipping->save();
        session()->flash('success', 'Update ShippingCharge successfully');
        return response()->json([
            'status' => true,
            'message' => 'Update ShippingCharge successfully',
        ]);
    }
    public function destroy ($id) {
        $shippingCharge = ShippingCharge::find($id);
        if (empty($shippingCharge)){
            return redirect()->route("shipping.create");
        }
        $shippingCharge->delete();
        session()->flash('success', 'Delete ShippingCharge successfully');
        return response()->json([
            'status' => true,
            'message' => 'Delete ShippingCharge successfully',
        ]);
    }
}
