<?php

declare(strict_types=1);

namespace App\People\People;

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
        $this->registerApiRoutes($this->app['router']);
        $this->registerAdminRoutes($this->app['router']);
    }

    /**
     * Registers api routes for the login and register.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerApiRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'api/v1/people',
            'middleware' => ['api', 'auth'],
            'namespace' => 'App\People\Http\Controllers\Api\V1\People',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('', 'Controller@importedPeople');

        });
    }

    /**
     * Registers admin routes..
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerAdminRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin/people',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\People\Http\Controllers\Admin\People',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->post('', 'Controller@importPeople');
        });
    }
}
