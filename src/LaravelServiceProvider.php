<?php

namespace Silber\PageCache;

use Illuminate\Support\ServiceProvider;
use Silber\PageCache\Console\ClearCache;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(ClearCache::class);

        $this->app->singleton(Cache::class, function () {
            $instance = new Cache($this->app->make('files'));

            return $instance->setContainer($this->app);
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/page-cache.php' => config_path('page-cache.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/page-cache.php', 'page-cache');
    }
}
