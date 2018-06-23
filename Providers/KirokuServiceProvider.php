<?php

namespace Modules\Kiroku\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class KirokuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('kiroku.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../Config/logging.php' => config_path('logging.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../Config/log-viewer.php' => config_path('log-viewer.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'config'
        );

        // publish vendor views
        $this->publishes([
            __DIR__ . '/../Resources/views/vendor/log-viewer' => resource_path('views/vendor/log-viewer'),
        ], 'config');
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/kiroku');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/kiroku';
        }, \Config::get('view.paths')), [$sourcePath]), 'kiroku');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/kiroku');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'kiroku');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'kiroku');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}