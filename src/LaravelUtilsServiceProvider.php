<?php

namespace Codeheures\LaravelUtils;

use Illuminate\Support\ServiceProvider;

class LaravelUtilsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot() {
        // Get namespace
        $nameSpace = $this->app->getNamespace();

        // Routes
        $this->app->router->group(['namespace' => $nameSpace ], function()
        {
            require __DIR__.'/routes/web.php';
        });

        // Config
        $this->publishes([
            __DIR__.'/config' => base_path('config')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {

    }
}