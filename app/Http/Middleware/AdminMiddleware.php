<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika sudah login tapi bukan admin, redirect sesuai role
        if (auth()->user()->role !== 'admin') {
            // Jika siswa, redirect ke dashboard siswa
            if (auth()->user()->role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
            // Untuk role lain, redirect ke home
            return redirect('/');
        }

        return $next($request);
    }
}