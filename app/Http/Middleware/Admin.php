<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,): Response
    {
        $users = Auth::user();
        $admin='admin@gmail.com';
        if($users&&$users->email == $admin){
        return $next($request);
        }
        return response()->json(['error' => 'Forbidden'], 403);

    }
}



