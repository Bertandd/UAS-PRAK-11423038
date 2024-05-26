<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Ambil pengguna saat ini
        $user = Auth::user();

        // Periksa apakah pengguna memiliki peran yang sesuai
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect atau berikan respons sesuai dengan kebijakan keamanan Anda
        // return abort(403, 'Unauthorized');
        //return route
        return redirect()->route('checkRole');
    }
}
