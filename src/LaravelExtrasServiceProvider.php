<?php

namespace Teners\LaravelExtras;

use Illuminate\Support\ServiceProvider;
use Teners\LaravelExtras\Commands\ClearLogCommand;
use Teners\LaravelExtras\Commands\MakeBladeCommand;
use Teners\LaravelExtras\Commands\MakeTraitCommand;

class LaravelExtrasServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishResources();
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    private function registerCommands()
    {
        $this->commands([
            ClearLogCommand::class,
            MakeBladeCommand::class,
            MakeTraitCommand::class
        ]);
    }

    private function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-extras.php' => config_path('laravel-extras.php'),
        ], 'extras-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_files_table.php' => database_path('migrations/' . now()->format('Y_m_d_His') . '_create_files_table.php'),
        ], 'extras-migrations');
    }
}
