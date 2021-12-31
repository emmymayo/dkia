<?php

namespace App\Console;

use App\Events\MeetingDeleted;
use App\Services\EClass\Zoom\Meeting\Meeting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            DB::table('notices')->where('expires_at','<',now()->subDay())->delete();
        })->daily();
        
        $schedule->call(function(){
           $old_classes =  DB::table('e_classes')->where('start_time','>',now()->subDay())->get();
           foreach($old_classes as $e_class){
               $meeting = new Meeting();
               try {
                $meeting->delete($e_class->zoom_meeting_id);
                MeetingDeleted::dispatch($e_class);
               } catch (\Throwable $th) {
                   
               }
               
              
           }

        })->everyMinute();
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
