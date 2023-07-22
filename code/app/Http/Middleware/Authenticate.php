<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * @var bool $refreshed If the token was refreshed
     */
    private $refreshed = false;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        // If the token was refreshed and the user is still authenticated (eg didn't logout)
        if ($this->refreshed && $newToken = $this->getGuard()->getToken()) {
            return $response->withCookie(AuthController::createJwtCookie($newToken));
        } else {
            return $response;
        }
    }

    /**
     * If we get to the unauthenticated function, attempt refreshing the JWT cookie
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->hasCookie(AuthController::JWT_COOKIE)) {
            try {
                $this->getGuard()->setToken($this->getGuard()->setRequest($request)->refresh());
                $this->refreshed = true;
                return;
            } catch (Exception $_) {
                // Don't need to deal with the JWT exceptions, if it doesn't work, just fall through to the parent
            }
        }
        parent::unauthenticated($request, $guards);
    }

    /**
     * @return \Tymon\JWTAuth\JWTGuard
     */
    private function getGuard()
    {
        return auth();
    }
}
