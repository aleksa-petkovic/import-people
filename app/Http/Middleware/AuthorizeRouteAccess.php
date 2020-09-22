<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Checks if the user has permissions to access the current action, and throws
 * an `AccessDeniedHttpException` if they don't.
 */
class AuthorizeRouteAccess
{
    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * Create a new middleware instance.
     *
     * @param Sentinel $sentinel A Sentinel instance.
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming request.
     * @param Closure $next    The next middleware to run.
     *
     * @throws AccessDeniedHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if (!$this->sentinel->hasAccess($route->getActionName())) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
