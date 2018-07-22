<?php

namespace Ancora\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class VerifyJWTToken extends BaseMiddleware
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
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'Token not provided', 401);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            try {
                $newToken = $this->auth->setRequest($request)->parseToken()->refresh();

                $user = $this->auth->setToken($newToken)->toUser();

                app('auth')->setUser($user);

                $response = $next($request);
                $response->headers->set('BearerToken', 'Bearer '.$newToken);

                return $response;

            } catch (TokenBlacklistedException $e) {
                return $this->respond('tymon.jwt.invalid', 'Token in blacklist', 401, [$e]);
            } catch (JWTException $e) {
                return $this->respond('tymon.jwt.invalid', 'Invalid token', 401, [$e]);
            }
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', 'User not found', 404);
        }

        return $next($request);
    }
}
