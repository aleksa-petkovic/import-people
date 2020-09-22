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
    }


    /**
     * Registers routes for the login.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerAuthRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'middleware' => ['web', 'guest'],
            'namespace' => 'App\Auth\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('login', 'Controller@index');
            $router->post('login', 'Controller@login');
            $router->get('register', 'Controller@registerForm');
            $router->post('register', 'Controller@register');

        });

        $attributes = [
            'middleware' => ['web', 'auth'],
            'namespace' => 'App\Auth\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->post('logout', 'Controller@logout');
        });
    }
}
