<?php

namespace Librevlad\Leadex;

use Illuminate\Support\ServiceProvider;

class LeadexServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return  void
     */
    public function register() {

        if ($this->app->runningInConsole()) {
        $this->publishes([
        __DIR__.'/../config/config.php' => config_path('leadex.php'),
        ], 'config');
        }

    }

    /**
     * Bootstrap services.
     *
     * @return  void
     */
    public function boot() {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'leadex');
    }
}
