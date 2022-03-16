<?php

namespace App\Console;

use App\Models\JfUserPersonal;
use App\Models\JfUserPublic;
use App\Traits\UserTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use UserTrait;
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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $day_7_before = date('Y-m-d 23:59:59', strtotime('-7 days'));
            $users = JfUserPersonal::query()->where('created_at', '<', $day_7_before)
                ->where('web_id', self::webId())
                ->get();
            foreach ($users as $user) {
                $data = [
                    'web_id' => self::webId(),
                    'user_id' => 0,
                    'master_id' => 0,
                    'user_name' => $user->user_name,
                    'company_name' => $user->company_name,
                    'mobile' => $user->mobile,
                    'source' => $user->source,
                    'created_at' => date('Y-m-d H:i:s', time())
                ];
                JfUserPublic::query()->insert($data);
                JfUserPersonal::query()->where('id', $user->id)->delete();
            }


        })->daily();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
