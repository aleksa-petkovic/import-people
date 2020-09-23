<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Makes sure the user is authenticated.
 *
 * If they are, the request is passed on.
 *
 * Otherwise, the user will be redirected to the `/admin/login` path (this is
 * currently hard-coded), or throws an `UnauthorizedHttpException` in case of an
 * AJAX request.
 */
class Authenticate
{
    /**
     * A Sentinel instance.
     */
    private Sentinel $sentinel;

    /**
     * Create a new middleware instance.
     *
     * @param Sentinel    $sentinel    A Sentinel instance.
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming request.
     * @param Closure $next    The next middleware.
     *
     * @throws UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->sentinel->guest()) {
            if ($request->expectsJson()) {
                throw new UnauthorizedHttpException('token', 'Missing auth token');
            }

            return redirect()->guest('/login');
        }

        return $next($request);
    }
}
