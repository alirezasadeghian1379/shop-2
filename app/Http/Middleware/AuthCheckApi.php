<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthCheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!JWTAuth::getToken()) return Response::error('error', 'لطفا ابتدا وارد شوید', 401);
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) return Response::error('error', 'کاربری یافت نشد!', 401);
            auth()->guard('api')->setUser($user);
        } catch (TokenExpiredException  $e) {
            return Response::error('error', 'توکن منقضی شده است، لطفا دوباره توکن دریافت  کنید', 401);
        } catch (TokenBlacklistedException $e) {
            return Response::error('error', 'توکن بلاک شده است، لطفا دوباره لاگین کنید', 401);
        } catch (JWTException $e) {
            return Response::error('error', 'توکن نامعتبر یا منقضی شده', 401);
        } catch (Throwable $e) {
            return Response::error('error', $e->getMessage(), 500);
        }
        return $next($request);
    }
}
