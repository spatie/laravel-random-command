<?php

namespace Spatie\RandomCommand;

use Illuminate\Console\Scheduling\Schedule;
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

        $this->app->booted(function () {
            $hour = cache('random.hour') ?? rand(0, 23);
            $minute = cache('random.minute') ?? rand(0, 59);

            cache(['random.hour' => $hour], now()->endofday());
            cache(['random.minute' => $minute], now()->endofday());

            $schedule = $this->app->make(Schedule::class);
            $schedule->command('random')->dailyAt("{$hour}:{$minute}");
        });
    }
}
