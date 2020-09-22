<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AppServiceProvider extends BaseServiceProvider
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
        $this->registerHomepageRoutes($this->app['router']);
        $this->registerAdminRoutes($this->app['router']);
    }

    /**
     * Registers the home page route.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerHomepageRoutes(RegistrarContract $router): void
    {
        // Website homepage route.
        $attributes = [
            'middleware' => ['web'],
            'namespace' => 'App\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('', 'HomeController@index');
        });
    }

    /**
     * Registers some basic admin panel routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerAdminRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\Http\Controllers\Admin',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            // admin panel home page.
            $router->get('', 'HomeController@index');;
        });
    }
}
