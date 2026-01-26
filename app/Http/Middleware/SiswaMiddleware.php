<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika sudah login tapi bukan siswa, redirect ke home/dashboard sesuai role
        if (auth()->user()->role !== 'siswa') {
            // Jika admin, redirect ke dashboard admin
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // Untuk role lain, bisa redirect ke home
            return redirect('/');
        }

        return $next($request);
    }
}