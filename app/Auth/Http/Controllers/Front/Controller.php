<?php

declare(strict_types=1);

namespace App\Auth\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class Controller extends BaseController
{
    /**
     * Show login form
     *
     * @return View
     */
    public function index(): View
    {
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
            $default = URL::action('App\Http\Controllers\Admin\HomeController@index');

            return Redirect::intended($default);
        }

        return Redirect::action('App\Http\Controllers\Admin\LoginController@index')
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
}
