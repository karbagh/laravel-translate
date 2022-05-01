<?php

namespace Karbagh\LaravelTranslate\Providers;

use Illuminate\Support\Str;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

class TranslationServiceProvider extends BaseTranslationServiceProvider
{
    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__. '/../../config/translate.php', 'laravel-translate-config');
    }

    public function boot()
    {
        if ($this->app->runningInConsole() && !Str::contains($this->app->version(), 'Lumen')) {
            $this->publishes([
                __DIR__. '/../../config/translate.php' => config_path('translate.php'),
            ], 'karbagh/laravel-translate');

            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        }
    }

    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            $class = config('translate.loader.service');

            return new $class($app['files'], $app['path.lang']);
        });
    }
}
