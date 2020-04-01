<?php

namespace Spatie\RandomCommand;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class RandomCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RandomCommand::class,
            ]);
        }
        
        $this->app->booted(function () {
            $hour = cache(['random.hour' => rand(0, 23);], now()->endofday();
            $minute = cache(['random.minute' => rand(0, 59);], now()->endofday();
            
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('random')->dailyAt("{$hour}:{$minute}");
        });
    }
}
