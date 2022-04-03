<?php

namespace App\Console;
use App\Models\Lead;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $to_name = 'Salvo';
                $to_email = 'salvatoredicaro93@gmail.com';

                $lead = Lead::find(1);

                Mail::send('mails.assignment', ["lead" => $lead], function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Assegnazione lead');
                    $message->from('postmaster@creditodigital.it', 'Avvera');
                });
        })->hourly();
        // $schedule->command('inspire')->hourly();
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
