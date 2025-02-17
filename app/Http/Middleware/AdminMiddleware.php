<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user') || Session::get('user')->profil !== 'admin') {
            return redirect('/login')->with('error', 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
