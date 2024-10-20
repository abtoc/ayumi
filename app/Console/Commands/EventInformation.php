<?php

namespace App\Console\Commands;

use App\Models\EventDate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EventInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayumi:event-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初日・最終日・倍率があるイベントを案内する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = EventDate::query()
                   ->where('date', today());
        if($query->exists()){
            Artisan::call('ayumi:notification e217db92-4612-4576-a377-80f0b00c8faa');
        }
    }
}
