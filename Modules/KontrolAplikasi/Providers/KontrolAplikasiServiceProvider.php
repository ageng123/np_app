<?php

namespace Modules\KontrolAplikasi\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class KontrolAplikasiServiceProvider extends ServiceProvider
{
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
        $this->loadMigrationsFrom(module_path('KontrolAplikasi', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('KontrolAplikasi', 'Config/config.php') => config_path('kontrolaplikasi.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('KontrolAplikasi', 'Config/config.php'), 'kontrolaplikasi'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/kontrolaplikasi');

        $sourcePath = module_path('KontrolAplikasi', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/kontrolaplikasi';
        }, \Config::get('view.paths')), [$sourcePath]), 'kontrolaplikasi');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/kontrolaplikasi');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'kontrolaplikasi');
        } else {
            $this->loadTranslationsFrom(module_path('KontrolAplikasi', 'Resources/lang'), 'kontrolaplikasi');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('KontrolAplikasi', 'Database/factories'));
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
