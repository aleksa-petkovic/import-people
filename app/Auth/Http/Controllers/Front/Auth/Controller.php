<?php

declare(strict_types=1);

namespace App\Auth\Http\Controllers\Front\Auth;

use App\Auth\Auth\WebAuthService;
use App\Auth\Http\Requests\Front\RegisterRequest;
use App\Auth\Auth\WebAuthService as LoginManager;
use App\Http\Controllers\Controller as BaseController;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class Controller extends BaseController
{
    /**
     * Show login form
     *
     * @param Sentinel $sentinel A Sentinel instance.
     *
     * @return mixed
     */
    public function loginForm(Sentinel $sentinel)
    {
        if ($sentinel->getUser()) {
            return Redirect::action('App\Http\Controllers\Front\HomeController@index');
        }

        return view('login');
    }

    /**
     * Attempts to log the user in, and redirects them to the admin panel home
     * page if successful, or back to the login form otherwise.
     *
     * @param Request      $request      The current request instance.
     * @param LoginManager $loginManager A LoginManager instance.
     *
     * @return RedirectResponse
     */
    public function login(Request $request, LoginManager $loginManager): RedirectResponse
    {
        if ($loginManager->login($request->all())) {
            return Redirect::action('App\Http\Controllers\Front\HomeController@index');
        }

        return Redirect::action('App\Auth\Http\Controllers\Front\Auth\Controller@loginForm')
            ->withErrors($loginManager->getErrors())
            ->withInput();
    }

    /**
     * Logs the user out, and redirects them back to the login form.
     *
     * @param LoginManager $loginManager A LoginManager instance.
     *
     * @return RedirectResponse
     */
    public function logout(LoginManager $loginManager): RedirectResponse
    {
        $loginManager->logout();

        return Redirect::action('App\Http\Controllers\Admin\LoginController@index')->with('loggedOut', true);
    }

    /**
     * Displays register form.
     *
     * @return View
     */
    public function registerForm(): view
    {
        return view('register');
    }

    /**
     * Create and activate new user with member role.
     *
     * @param RegisterRequest $request  A RegisterRequest instance.
     * @param WebAuthService  $webAuthService A WebAuthService instance.
     *
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request, WebAuthService $webAuthService): RedirectResponse
    {
        $inputData = $request->all();

        $userConfig = [
            'email' => Arr::get($inputData, 'email', ''),
            'password' => Arr::get($inputData, 'password'),
            'first_name' => Arr::get($inputData, 'first_name', ''),
            'last_name' => Arr::get($inputData, 'last_name', ''),
        ];

        $webAuthService->registerUser($userConfig);

        return Redirect::action(self::class . '@loginForm');
    }
}
