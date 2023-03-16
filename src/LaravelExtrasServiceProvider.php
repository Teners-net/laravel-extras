<?php

namespace Platinum\LaravelExtras;

use Illuminate\Support\ServiceProvider;
use Platinum\LaravelExtras\Commands\ClearLogCommand;
use Platinum\LaravelExtras\Commands\MakeBladeCommand;
use Platinum\LaravelExtras\Commands\MakeTraitCommand;

class LaravelExtrasServiceProvider extends ServiceProvider
{
  public function boot()
  {
      $this->publishes([
        __DIR__. '/../config/laravel-extras.php' => config_path('laravel-extras.php'),
      ], 'config');

      $this->publishes([
        __DIR__. '/../database/migrations/create_files_table.php' => base_path('database/migrations/2023_01_30_005200_create_files_table.php'),
      ], 'migrations');
  }

  public function register()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        ClearLogCommand::class,
        MakeBladeCommand::class,
        MakeTraitCommand::class
      ]);
    }
  }
}