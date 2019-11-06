<?php

namespace Indigoram89\Laravel\Translations;

use Illuminate\Support\ServiceProvider;
use Indigoram89\Laravel\Translations\Commands\PullCommand;
use Indigoram89\Laravel\Translations\Commands\PushCommand;
use Indigoram89\Laravel\Translations\Contracts\Drivers as DriversContract;
use Indigoram89\Laravel\Translations\Contracts\Repository as RepositoryContract;
use Indigoram89\Laravel\Translations\Contracts\Translations as TranslationsContract;

class TranslationsServiceProvider extends ServiceProvider
{
	/**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

	/**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/translations.php' => config_path('translations.php'),
        ]);

        $this->commands(PushCommand::class, PullCommand::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();
        
        $this->registerDrivers();
        
        $this->registerTranslations();
    }

    protected function registerRepository()
    {
        $this->app->singleton('translations.repository', function ($app) {
            return new Repository($app);
        });

        $this->app->alias('translations.repository', RepositoryContract::class);
    }

    protected function registerDrivers()
    {
        $this->app->singleton('translations.drivers', function ($app) {
            return new Drivers($app);
        });

        $this->app->alias('translations.drivers', DriversContract::class);
    }

    protected function registerTranslations()
    {
        $this->app->singleton('translations', function ($app) {
            return new Translations($app);
        });

        $this->app->alias('translations', TranslationsContract::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'translations.repository',
            'translations.drivers',
            'translations',

            RepositoryContract::class,
            DriversContract::class,
            TranslationsContract::class,
        ];
    }
}
