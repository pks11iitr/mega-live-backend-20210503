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
        'App\Console\Commands\CallNotifications',
        'App\Console\Commands\AutomaticMessages',
        'App\Console\Commands\AutomaticLikes',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('call:notifications')
            ->withoutOverlapping()
            ->cron('* * * * *');
        $schedule->command('automatic:messages')
            ->withoutOverlapping()
            ->cron('* * * * *');
        $schedule->command('automatic:likes')
            ->withoutOverlapping()
            ->cron('* * * * *');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
