<?php

namespace :uc:vendor\:uc:package;

use Illuminate\Support\ServiceProvider;

class :uc:packageServiceProvider extends ServiceProvider
{
  /**
   * Perform post-registration booting of services.
   *
   * @return void
   */
  public function boot()
  {
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
    $this->mergeConfigFrom(__DIR__.'/../config/:lc:package.php', ':lc:package');

    // Register the service the package provides.
    $this->app->singleton(':uc:package', function ($app) {
      return new :uc:package;
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [
      ':uc:package'
    ];
  }

  /**
   * Console-specific booting.
   *
   * @return void
   */
  protected function bootForConsole()
  {
    // Collect vendor name, and package name.
    $vendorName = basename(realpath(__DIR__ . '/../../'));
    $packageName = basename(realpath(__DIR__ . '/../'));

    // Publishing the configuration file.
    $this->publishes([
        __DIR__.'/../config/:lc:package.php' => config_path(':lc:package.php'),
    ], ':lc:package.config');

    // Register package commands.
    $commands = [];
    foreach (glob(__DIR__ . '/Console/Commands/*.php') as $row) {
      // init class path
      $classPath = '\\:uc:vendor\\:uc:package\\Console\\Commands\\';

      // class path with command file class name
      $commandFileClass = str_replace('.php', '', basename($row));

      $classPath .= $commandFileClass;

      $commands[] = $classPath;
    }

    $this->commands($commands);
  }
}
