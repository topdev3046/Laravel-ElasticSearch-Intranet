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
        Commands\DocumentsArchiveExpired::class,
        Commands\DocumentsMarkAsRead::class,
        Commands\DocumentsResetTypes::class,
        Commands\DocumentsPublishForms::class,
        Commands\DocumentsSendPublished::class,
        // Commands\FavoritesCreateCategories::class,
        Commands\UsersAssignRoles::class,
        Commands\UsersLogout::class,
        Commands\JuristenPortalImport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('documents:archive-expired')
            ->dailyAt('03:00');
            
        $schedule->command('documents:send-published')
            ->everyFiveMinutes()->withoutOverlapping();
    }
}
