<?php

namespace TomaszTryka\Helpers\Providers;

use TomaszTryka\Helpers\Commands\CreateCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateCommand::class
            ]);
        }

        if (File::exists(app_path('Helpers\helpers.php'))) {
            require_once app_path('Helpers\helpers.php');
        }
    }
}