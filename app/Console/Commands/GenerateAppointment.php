<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Date;
use App\Models\Appointment;
use Morilog\Jalali\Jalalian;
use Illuminate\Console\Command;

class GenerateAppointment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
         $startDate=Carbon::now()->startOfYear();
        $endDate=$startDate->copy()->endOfYear();
        $progressbar=$this->output->createProgressBar(365);

        for($date=$startDate; $date->lte($endDate);$date->addDay()){
            $day=Date::create(['date'=>$date->format('Y-m-d')]);
            $startTime=Carbon::createFromTime(0,0);
            $endTime=Carbon::createFromTime(23,55);
            $this->info($day);
            $this->newLine();
            for($time=$startTime; $time->lte($endTime); $time->addMinutes(5)){
                $start_time=$time->toTimeString();
                $end_time=$time->copy()->addMinutes(5)->toTimeString();
                $times=$start_time.'_'.$end_time;
                Appointment::create([
                    'date_id'=>$day->id,
                    'time'=>$times,
                ]);

            }
        
            $progressbar->advance();
        }
        return 0;

        


    }
}
