<?php

namespace App\Console\Commands;

use App\Models\ClientEvent;
use Illuminate\Console\Command;

class CreateEventDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ayumi:create-event-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '相互依頼用の日付テーブルを作成する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = today();
        $events = ClientEvent::query()
                    ->where('start_on', '<=', today())
                    ->where('end_on', '>=', today())
                    ->get();
        foreach($events as $event) {
            \Log::info(
                $event->liver_name.'さんの'.$event->event_name.'の'.$today->format('Y-m-d').'分の相互依頼用のイベント日付を作成します'
            );
            $event->client_event_dates()->create(['date' => $today]);
        }
    }
}
