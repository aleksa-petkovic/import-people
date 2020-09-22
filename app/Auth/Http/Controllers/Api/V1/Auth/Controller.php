<?php

declare(strict_types=1);

namespace App\Auth\Http\Controllers\Api\V1\Auth;

use App\Auth\Auth\ApiAuthService;
use App\Auth\Http\Requests\Api\Auth\AuthenticateRequest;
use App\Auth\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Controller extends BaseController
{
    /**
     * Authenticate user.
     *
     * @param AuthenticateRequest $request        An AuthenticateRequest instance.
     * @param ApiAuthService      $apiAuthService An ApiAuthService instance.
     *
     * @throws BadRequestHttpException
     *
     * @return JsonResponse
     */
    public function authenticate(AuthenticateRequest $request, ApiAuthService $apiAuthService): JsonResponse
    {
        $user = $apiAuthService->authenticate(
            $request->input('credentials.email'),
            $request->input('credentials.password'),
        );

        return new JsonResponse([
            'auth_token' => $user->auth_token,
        ], 201);
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request        A register request instance.
     * @param ApiAuthService  $apiAuthService A Api auth service instance.
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, ApiAuthService $apiAuthService): JsonResponse
    {
       $user = $apiAuthService->register(
            $request->get('email'),
            $request->get('password'),
            $request->get('first_name'),
            $request->get('last_name'),
        );

        return new JsonResponse($user, 201);
    }
}
