<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ShipperAuthenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('shipper.login');
    }

    protected function authenticate($request, array $guards)
    {
        if (Auth::guard('shipper')->check()) {
            return $this->auth->shouldUse('shipper');
        }

        $this->unauthenticated($request, ['shipper']);
    }
}
