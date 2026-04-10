<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB TAMBAHKAN INI



class IsAdmin
{

    public function handle(Request $request, Closure $next)
    {
        // Gunakan Auth::check() dan Auth::user()
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, balikkan ke home dengan pesan error
        return redirect('/')->with('error', 'Maaf, akses khusus admin!');
    }
}
