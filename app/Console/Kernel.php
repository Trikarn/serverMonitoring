<?php

namespace App\Console;

use App\Models\Server;
use App\Models\ServerInfo;
use App\Models\Telegram;
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
        
        $schedule->call(function () {
            $server = new Server();
            $serverInfo = new ServerInfo();
            $telegram = new Telegram();

            $servers = $server->servers();

            foreach($servers as $serverOne) {
                $time = time();
                $tempProc = rand(30,100);
                $loadProc = rand(20,100);
                $tempHard = rand(50, 100);
                $discMem = rand(307200, 1048576);
                $ram = rand(307200, 1048576);
                $speedCool = rand(1200,2000);
                $enabledRand = rand(0,100);
                if ($enabledRand >= 10) {
                    $enabled = true;
                } else {
                    $enabled = false;
                }

                $newInfo = $serverInfo->add([
                    'server' => $serverOne->id,
                    'enabled' => $enabled,
                    'time' => $time,
                    'temp_proces' => $tempProc,
                    'load_proces' => $loadProc,
                    'temp_hard' => $tempHard,
                    'disc_mem' => $discMem,
                    'ram' => $ram,
                    'speed_cooler' => $speedCool
                ]);

                $critTempProc = 90;
                $critTempHDD = 85;
                $critLoadProc = 95;
                $critRam = 102400;
                
                $ram = round($ram*1024,2); 

                if($enabled != 1) $message = "Сервер $serverOne->name выключен!"."\n";

                $enabled = $enabled == 1 ? 'включен' : 'выключен';

                $message = "Сервер: $serverOne->name \nСостояние: $enabled \n";
                $messageCheckSend = $message;
                
                if($tempProc >= $critTempProc) $message .= "Критическая температура процессора: $tempProc °C"."\n";
                if($tempHard >= $critTempHDD) $message .= "Критическая температура HDD: $tempHard °C"."\n";
                if($loadProc >= $critLoadProc) $message .= "Критическая нагрузка процессора: $loadProc %"."\n";
                if($ram <= $critRam) $message .= "Нехватка ОЗУ. Свободное ОЗУ: $ram МБ"."\n";

                if($message == $messageCheckSend) continue; 

                $botsData = $telegram->telegrams([
                    'userId' => $serverOne->owner
                ]);

                $message = urlencode($message);

                foreach($botsData as $botData) {
                    $sendToTelegram = fopen("https://api.telegram.org/bot".$botData->token."/sendMessage?chat_id=".$botData->chat."&text=$message", "r");
                }
            }
        })->everyFiveMinutes();
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
