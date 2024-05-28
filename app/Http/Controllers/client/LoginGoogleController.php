<?php

namespace App\Http\Controllers\client;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback() {
        try {
            // Kiểm tra xem có tham số lỗi trong URL không
            if (request()->has('error')) {
                session()->flash('error', 'You have declined the Google login.');
                return redirect()->route('account.login');
            }
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                session()->flash('success','Login google successfully');
                return redirect()->route("client.home");
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'password' => encrypt('123456789')
                    ]);
                Auth::login($newUser);
                session()->flash('success','Login google successfully');
                return redirect()->route("client.home");
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
