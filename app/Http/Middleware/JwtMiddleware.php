<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exception\TokenExpiredException;
use Tymon\JWTAuth\Exception\TokenInvalidException;


class JwtMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        try{
            $user =JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof TokenInvalidException){
                return response()->json(['status'=>'token is invalid']);
            }else if($e instanceof TokenExpiredException){
                return response()->json(['status'=>'Token is expired']);
            }else{
                return response()->json(['status'=>'Authorization Token is not found']);
            }
        }
    
        return $next($request);
    } 
}

  