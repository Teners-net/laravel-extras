<?php

namespace Platinum\LaravelExtras;

use Illuminate\Support\ServiceProvider;
use Platinum\LaravelExtras\Commands\MakeTraitCommand;

class LaravelExtrasServiceProvider extends ServiceProvider
{
  public function boot()
  {
      
  }

  public function register()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        MakeTraitCommand::class
      ]);
    }
  }
}