<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
        return view('client.account.address');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route("account.login")->with('success', 'You have been logged out');
    }
}
