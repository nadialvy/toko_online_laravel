<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try
        {
            $user=JWTAuth::parseToken()->authenticate();
        }
        catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status'=>'token is invalid']);
            } else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status'=>'token is expired']);
            } else {
                return response()->json(['status'=>'authorization token not found']);
            }
        }
        return $next($request);
    }
}
