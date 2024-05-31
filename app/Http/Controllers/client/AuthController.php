<?php

namespace App\Http\Controllers\client;

use App\Models\User;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        return view('client.account.login');
    }
    public function register() {
        return view('client.account.register');
    }
    public function processRegister(Request $request) {
        $validate = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validate->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            session()->flash('success', 'You are register successfully');
            return response()->json([
                'status' => true,
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ]);
        }
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()) {

            if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], $request->get('remember'))){

                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }

                return redirect()->route("account.profile")->with('success', 'You are login successfully');;
            }else {
                // session()->flash('error', 'Either email or password is incorrect');
                return redirect()->route("account.login")->withInput($request->only('email'))
                ->with('error', 'Either email or password is incorrect');
            }
        }else {
            return redirect()->route("account.login")->withErrors($validator)->withInput($request->only('email'));
        }
    }
    public function profile() {
        return view('client.account.profile');
    }
    public function address() {
        $user = Auth::user();
        $provinces = Province::orderBy('id', 'ASC')->get();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();

        $province = null;
        $district = null;
        $ward = null;

        if ($customerAddress) {
            $province = Province::find($customerAddress->province_id);
            $district = District::find($customerAddress->district_id);
            $ward = Ward::find($customerAddress->ward_id);
        }

        $data['provinces'] = $provinces;
        $data['customerAddress'] = $customerAddress;
        $data['customerProvince'] = $province;
        $data['customerDistrict'] = $district;
        $data['customerWard'] = $ward;


        return view('client.account.address', $data);
    }
    public function updateAddress (Request $request) {
        $user = Auth::user();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();
        if (!$customerAddress) {
            return response()->json([
                'message' => 'Address not found',
                'status' => false,
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Fix the error',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $customerAddress->first_name = $request->first_name;
        $customerAddress->last_name = $request->last_name;
        $customerAddress->email = $request->email;
        $customerAddress->province_id = $request->province;
        $customerAddress->district_id = $request->district;
        $customerAddress->ward_id = $request->ward;
        $customerAddress->address = $request->address;
        $customerAddress->phone = $request->phone;
        $customerAddress->save();
        session()->flash('success', 'Updated customer address successfully');
        return response()->json([
            'status' => true,
            'message' => 'Update address successfully',
        ]);
    }

    public function orders () {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        $data['orders'] = $orders;

        return view("client.account.order", $data);
    }
    public function orderDetails($id) {
        $data=[];
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $id)->get();

        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        return view('client.account.orderdetail', $data);
    }

    public function wishlist() {

        $wishlists = Wishlist::where('user_id',Auth::user()->id)->with('product')->get();
        $data['wishlists'] = $wishlists;

        return view('client.account.wishlist', $data);
    }

    public function removeProductFromWishlist(Request $request) {
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id', $request->product_id)->first();
        if ($wishlist == null){
            session()->flash('error', 'Product already removed');
            return response()->json([
                'status' => true,
                'message' => 'Product already removed',
            ]);
        }
        $wishlist->delete();
        session()->flash('success', 'Product remove successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product remove successfully',
        ]);

    }


    public function logout(){
        Auth::logout();
        return redirect()->route("account.login")->with('success', 'You have been logged out');
    }
}
