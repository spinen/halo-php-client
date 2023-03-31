<?php

namespace Spinen\Halo\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Spinen\Halo\Http\Middleware\Filter;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMiddleware();

        $this->registerPublishes();

        $this->registerRoutes();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/halo.php', 'halo');
    }

    /**
     * Register the middleware
     *
     * If a route needs to have the QuickBooks client, then make sure that the user has linked their account.
     */
    public function registerMiddleware()
    {
        $this->app->router->aliasMiddleware('halo', Filter::class);
    }

    /**
     * There are several resources that get published
     *
     * Only worry about telling the application about them if running in the console.
     */
    protected function registerPublishes()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

            $this->publishes(
                groups: 'halo-config',
                paths: [
                    __DIR__.'/../../config/halo.php' => config_path('halo.php'),
                ],
            );

            $this->publishes(
                groups: 'halo-migrations',
                paths: [
                    __DIR__.'/../../database/migrations' => database_path('migrations'),
                ],
            );
        }
    }

    /**
     * Register the routes needed for the OAuth flow
     */
    protected function registerRoutes()
    {
        if (Config::get('halo.oauth.authorization_code.route.enabled')) {
            Route::group(
                attributes: [
                    'namespace' => 'Spinen\Halo\Http\Controllers',
                    'middleware' => Config::get('halo.oauth.authorization_code.route.middleware', ['web']),
                ],
                routes: fn () => $this->loadRoutesFrom(realpath(__DIR__.'/../../routes/web.php'))
            );
        }
    }
}
