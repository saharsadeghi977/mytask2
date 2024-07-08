<?php

namespace App\Console\Commands;
use App\Models\Appointment;
use App\Models\Date;
use Carbon\Carbon;

use Illuminate\Console\Command;

class CleanOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:old-records';

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
        $this->info('clean old records');
        Appointment::where('end_time','<',Carbon::now())->where('status','=','free')->delete();
        $dates=Date::where('date','<',Carbon::today())->get();
        foreach($dates as $date){
            if
            ($date->appointments()->where('status','!=','free')->count()==0){
                $date->delete();
            }
        }
        $this->info('old records cleaned successfully');
    }
}
