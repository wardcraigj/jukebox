<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\MpdListener::class,
	    Commands\UpdateMPD::class,
	    Commands\MpdWatchdog::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

	    $schedule->command('mpd:listen')->everyMinute()->withoutOverlapping();
	    $schedule->command('mpd:watchdog')->everyMinute()->withoutOverlapping();
    }
}
