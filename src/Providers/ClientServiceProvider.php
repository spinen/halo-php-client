<?php

namespace Spinen\Halo\Providers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Spinen\Halo\Api\Client as Halo;
use Spinen\Halo\Support\Builder;

/**
 * Class ClientServiceProvider
 *
 * Since this is deferred, it only needed to deal with code that has to do with the client.
 */
class ClientServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();

        $this->app->alias(Halo::class, 'Halo');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Builder::class,
            Halo::class,
        ];
    }

    /**
     * Register the client
     *
     * If the Halo id or roles are null, then assume sensible values via the API
     */
    protected function registerClient(): void
    {
        $this->app->bind(
            abstract: Builder::class,
            concrete: fn (Application $app): Builder => (new Builder())->setClient($app->make(Halo::class))
        );

        $this->app->bind(
            abstract: Halo::class,
            concrete: fn (Application $app): Halo => new Halo(Config::get('halo'), $app->make(Guzzle::class))
        );
    }
}
