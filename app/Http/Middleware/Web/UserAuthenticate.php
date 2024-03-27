<?php

namespace App\Http\Middleware\Web;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate {
    public function handle($request, Closure $next) {
        if (Auth::guard('web')->check()) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
