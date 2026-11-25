<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('akun_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
