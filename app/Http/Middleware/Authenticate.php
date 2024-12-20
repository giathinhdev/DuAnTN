<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Kiểm tra nếu đường dẫn có prefix 'admin' thì chuyển hướng đến trang login của admin
        if (!$request->expectsJson()) {
            return $request->is('admin/*') ? route('admin.login') : route('login');
        }

        return null;
    }
}
