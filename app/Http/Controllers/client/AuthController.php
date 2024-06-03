<?php

namespace App\Http\Controllers\client;

use App\Models\User;
use App\Models\Ward;
use App\Models\Order;
use App\Models\District;
use App\Models\Province;
use App\Models\Wishlist;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Mail\ReserPasswordEmail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'phone' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validate->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
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
        $user = User::where('id', Auth::user()->id)->first();
        // $customerAddress = CustomerAddress::where('user_id', $user->id)->first();

        $data['user'] = $user;
        return view('client.account.profile', $data);
    }

    public function updateProfile(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required'
        ]);

        if ($validator->passes()){
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            session()->flash('success','Update profile successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update profile successfully',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
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

    public function showChangePasswordForm() {
        return view('client.account.change-password');
    }
    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->passes()){

            $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();
            if (!Hash::check($request->old_password, $user->password)) {
                session()->flash('error', 'Your old password is incorrect, please try again');
                return response()->json([
                    'status' => true,
                ]);
            }
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            session()->flash('success','Update password successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update password successfully',
            ]);

        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function forgotPasswordForm() {
        return view('client.account.forgot-password');
    }
    public function processForgotPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|exists:users,email'
        ]);
        if ($validator->passes()){
            $token = Str::random(60);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);

            $user = User::where('email', $request->email)->first();
            $formData = [
                'token' => $token,
                'user' => $user,
                'mail_subject' => 'You have requested to reset password'
            ];
            // Send email here
            Mail::to($request->email)->send( new ResetPasswordEmail($formData));
            return redirect()->route("account.forgotPasswordForm")->with('success','Please check the inbox to reset password');
        }else {
            return redirect()->route("account.forgotPasswordForm")->withInput()->withErrors($validator);
        }
    }
    public function resetPassword($token) {
        $tokenExits = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenExits == null) {
            return redirect()->route("account.forgotPasswordForm")->with('error','Invalid request');
        }
        return view('client.account.reset-password', ['token' => $token]);
    }
    public function processResetPassword(Request $request) {
        $token = $request->token;
        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenObj == null) {
            return redirect()->route("account.forgotPasswordForm")->with('error','Invalid request');
        }
        $user = User::where('email', $tokenObj->email)->first();
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()){
            return redirect()->route("account.resetPassword", $token)->withErrors($validator);
        }
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        return redirect()->route("account.login",)->with('success','You already reset password successfully, please login here.');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route("account.login")->with('success', 'You have been logged out');
    }
}
