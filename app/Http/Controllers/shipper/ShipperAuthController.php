<?php

namespace App\Http\Controllers\shipper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShipperAuthController extends Controller
{
    public function index()
    {
        return view('shipper.login');
    }
    public function dashboard(){
        return view('shipper.dashboard');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::guard('shipper')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return redirect()->route('shipper.dashboard');
            } else {
                return redirect()->route('shipper.login')->with('error', 'Email or Password incorrect');
            }
        } else {
            return redirect()->route('shipper.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
    public function logout()
    {
        Auth::guard('shipper')->logout();
        return redirect()->route('shipper.login');
    }
}
