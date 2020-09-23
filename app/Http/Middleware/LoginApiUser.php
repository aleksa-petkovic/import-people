<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\Auth\ApiAuthService;
use App\Auth\Exceptions\InvalidTokenException;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginApiUser
{
    /**
     * A Sentinel instance.
     */
    private Sentinel $sentinel;

    /**
     * A ApiAuthService instance.
     */
    private ApiAuthService $apiAuthService;

    /**
     * @param Sentinel       $sentinel       Sentinel instance.
     * @param ApiAuthService $apiAuthService ApiAuthService instance.
     */
    public function __construct(Sentinel $sentinel, ApiAuthService $apiAuthService)
    {
        $this->sentinel = $sentinel;
        $this->apiAuthService = $apiAuthService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request Request instance.
     * @param Closure $next    Callback function.
     *
     * @throws UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $this->authenticateApiUser($request);
        } catch (InvalidTokenException $exception) {
            throw new UnauthorizedHttpException('token', 'Invalid authentication token.', $exception);
        }

        return $next($request);
    }

    /**
     * Authenticates the user via API, in case the correct headers are set.
     *
     * Logs the user into the app via Sentinel, so the user will be available
     * later on, no matter which method was used for logging in.
     *
     * @param Request $request Request instance.
     *
     * @return void
     */
    private function authenticateApiUser(Request $request): void
    {
        if ($request->headers->has('Authorization')) {
            $this->authenticate($request->header('Authorization'));
        }
    }

    /**
     * Authenticates a user with the access token.
     *
     * @param string $token The submitted access token.
     *
     * @throws InvalidTokenException
     *
     * @return void
     */
    private function authenticate(string $token): void
    {
        $user = $this->apiAuthService->findUserWithAuthToken($token);

        if (!$user) {
            throw new InvalidTokenException('Token is invalid');
        }

        $this->sentinel->setUser($user);
    }
}
