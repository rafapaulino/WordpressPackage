<?php

namespace rafapaulino\WordpressPackage;

use Illuminate\Support\ServiceProvider;

class WordpressPackageServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'rafapaulino');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'rafapaulino');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wordpresspackage.php', 'wordpresspackage');

        // Register the service the package provides.
        $this->app->singleton('wordpresspackage', function ($app) {
            return new WordpressPackage;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wordpresspackage'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/wordpresspackage.php' => config_path('wordpresspackage.php'),
        ], 'wordpresspackage.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/rafapaulino'),
        ], 'wordpresspackage.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/rafapaulino'),
        ], 'wordpresspackage.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/rafapaulino'),
        ], 'wordpresspackage.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
