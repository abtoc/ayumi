<?php

namespace App\Console\Commands;

use App\Models\ClientEventDate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScreenshotRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayumi:screenshot-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スクリーンショットの依頼を行う';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = ClientEventDate::query()
                    ->where('date', today())
                    ->where('collected', false);
        if($query->exists()){
            Artisan::call('ayumi:notification c499f6a0-3c6a-4a7b-beeb-14bf8d219115');
        }
    }
}
