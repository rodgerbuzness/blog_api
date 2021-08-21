<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $message = '';

        try{

            JWTAuth::parseToken()->authenticate();
            return $next($request);

        }
        catch(TokenExpiredException $e){
            $message = 'token expired';

        }
        catch(TokenInvalidException $e){
            $message = 'invalid token';

        }
        catch(JWTException $e){
            $message = 'provide token';

        }

        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
