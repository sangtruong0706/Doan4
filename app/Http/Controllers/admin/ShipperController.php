<?php

namespace App\Http\Controllers\admin;

use App\Models\Shipper;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShipperController extends Controller
{
    public function index(Request $request) {
        $shippers = Shipper::latest();
        if (!empty($request->get('keyword'))) {
            $shippers = $shippers->where('full_name','like','%'.$request->get('keyword').'%');
            $shippers = $shippers->orWhere('email','like','%'.$request->get('keyword').'%');
        }
        $shippers = $shippers->paginate(10);
        $data['shippers'] = $shippers;
        return view('admin.shipper.list', $data);
    }
    public function create() {
        $provinces = Province::orderBy('id', 'ASC')->get();

        $data['provinces'] = $provinces;
        return view('admin.shipper.create', $data);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|unique:shippers',
            'password' => 'required|min:5',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',

        ]);
        if ($validator->passes()){
            $shipper = new Shipper();
            $shipper->full_name = $request->full_name;
            $shipper->email = $request->email;
            $shipper->password = Hash::make($request->password);
            $shipper->phone = $request->phone;
            $shipper->address = $request->address;
            $shipper->status = $request->status;
            $shipper->province_id = $request->province;
            $shipper->district_id = $request->district;
            $shipper->ward_id = $request->ward;
            $shipper->save();
            session()->flash('success', 'Create shipper successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create shipper successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($shipper_id) {
        $provinces = Province::orderBy('id', 'ASC')->get();

        $shipper = Shipper::where('id',$shipper_id)->first();
        if ($shipper == null) {
            session()->flash('error', 'Shipper not found');
            return redirect()->route("shippers.index");
        }
        $province_shipper = Province::where('id', $shipper->province_id)->first();
        $district_shipper = District::where('id', $shipper->district_id)->first();
        $ward_shipper = Ward::where('id', $shipper->ward_id)->first();


        $data['shipper'] = $shipper;
        $data['provinces'] = $provinces;
        $data['province_shipper'] = $province_shipper;
        $data['district_shipper'] = $district_shipper;
        $data['ward_shipper'] = $ward_shipper;
        return view('admin.shipper.edit', $data);
    }
    public function update(Request $request, $shipper_id) {
        $shipper = Shipper::where('id',$shipper_id)->first();
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|unique:shippers,email,'.$shipper->id.',id',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ]);
        if ($validator->passes()){
            $shipper->full_name = $request->full_name;
            $shipper->email = $request->email;
            if ($request->password != '') {
                $shipper->password = Hash::make($request->password);
            }
            $shipper->phone = $request->phone;
            $shipper->status = $request->status;
            $shipper->address = $request->address;
            $shipper->province_id = $request->province;
            $shipper->district_id = $request->district;
            $shipper->ward_id = $request->ward;
            $shipper->save();
            session()->flash('success', 'Update shipper successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update shipper successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy($shipper_id) {
        $shipper = Shipper::where('id', $shipper_id)->first();
        if ($shipper == null) {
            session()->flash('error', 'Shipper not found');
            return response()->json([
                'status' => false,
                'message' => 'Shipper not found',
            ]);
        }
        $shipper->delete();
        session()->flash('success', 'Delete shipper successfully');
        return response()->json([
            'status' => true,
            'message' => 'shipper deleted successfully',
        ]);
    }
}
