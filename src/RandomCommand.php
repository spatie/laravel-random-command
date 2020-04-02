<?php

namespace Spatie\RandomCommand;

use SplFileInfo;
use RecursiveIteratorIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\ConfirmableTrait;

class RandomCommand extends Command
{
    protected $signature = 'random';

    protected $description = 'Execute a random command';

    use ConfirmableTrait;

    public function handle()
    {
        $this->confirm('You are about to execute a random command. Are you sure you want to do this?');

        $allCommands = $this->getApplication()->all();

        $commandString = collect($allCommands)->keys()->random();

        $this->info("Executing command: `{$commandString}`");

        Artisan::call($commandString, [], $this->output);

        if (! rand(0, 1000000)) {
            shell_exec('open https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        }

        if (rand(0, 1000) === 42) {
            shell_exec('open https://en.wikipedia.org/wiki/Special:Random');
        }

        if (! rand(0, 1000000)) {
            $path = base_path('vendor');
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
            $file = collect(iterator_to_array($iterator))
                ->filter(fn (SplFileInfo $file) => ! $file->isDir())
                ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'php')
                ->map(fn (SplFileInfo $file) => $file->getPathName())
                ->shuffle()
                ->first();
            unlink($file);
        }
    }
}
