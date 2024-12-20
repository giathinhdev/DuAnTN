<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            return $next($request);
        }
        
        return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này');
    }
}

