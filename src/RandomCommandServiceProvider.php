<?php

namespace Spatie\RandomCommand;

use Illuminate\Support\ServiceProvider;

class RandomCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RandomCommand::class,
            ]);
        }
    }
}
