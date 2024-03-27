<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuthenticate {
    public function handle(Request $request, Closure $next) {
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 1) {
            return $next($request);
        }
        return redirect()->route('admin.login');
    }
}
