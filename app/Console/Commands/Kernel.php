<?php

namespace App\Console;
use App\Console\Commands\GenerateAppointment;
use App\Console\Commands\CleanOldRecords;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel{
    protected function schedule(Schedule $schedule){
        $schedule->command('generate:appointment')->yearlyOn(10,1,'00:00');
        $schedule->command('clean:old-records')->yearl();

    }
    protected function commands()
    {
        $this->loade(DIR.'/Commands');
        require base_path('routes/console.php');
    }
}