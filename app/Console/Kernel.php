<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
 use App\Console\Commands\PublishTemplate;
 use App\Console\Commands\DirectMigrate;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    PublishTemplate::class,
    DirectMigrate::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
    {
        //
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
