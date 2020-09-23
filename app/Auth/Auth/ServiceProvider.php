<?php

declare(strict_types=1);

namespace App\Auth\Auth;

use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAuthRoutes($this->app['router']);
        $this->registerApiAuthRoutes($this->app['router']);
    }


    /**
     * Registers routes for the login.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerAuthRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'middleware' => ['web', 'guest'],
            'namespace' => 'App\Auth\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('login', 'Auth\Controller@loginForm');
            $router->post('login', 'Auth\Controller@login');
            $router->get('register', 'Auth\Controller@registerForm');
            $router->post('register', 'Auth\Controller@register');

        });

        $attributes = [
            'middleware' => ['web', 'auth'],
            'namespace' => 'App\Auth\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('logout', 'Auth\Controller@logout');
        });
    }

    /**
     * Registers api routes for the login and register.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerApiAuthRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'api/v1',
            'middleware' => ['api', 'guest'],
            'namespace' => 'App\Auth\Http\Controllers\Api\V1\Auth',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->post('authenticate', 'Controller@authenticate');
            $router->post('register', 'Controller@register');
        });
    }

}
