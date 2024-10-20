<?php

namespace App\UseCases\Api\Screenshot;

use App\Models\ClientEvent;
use App\Models\ClientEventDate;
use Illuminate\Support\Facades\Auth;


class IndexAction
{
    public function __invoke()
    {
        $result = [];

        // 未納品のイベントの数を数える
        $count = ClientEvent::query()
                    ->where('delivered', false)
                    ->count();

        // 未納品がなければ、スクショは不要
        if($count == 0){
            return [
                'need' => false,
                'dates' => [],
            ];
        }


        $dates = ClientEventDate::query()
                    ->select(['client_event_dates.id', 'client_event_dates.date', 'client_event_dates.client_event_id'])
                    ->join('client_events', 'client_event_dates.client_event_id', '=', 'client_events.id')
                    ->where('delivered', false)
                    ->where('collected', false)
                    ->orderBy('date', 'asc')
                    ->get();
        foreach ($dates as $date) {
            if(!array_key_exists($date->date->format('Y-m-d'), $result)){
                $result[$date->date->format('Y-m-d')] = [];
            }
            $count = $date->screenshots()
                        ->where('user_id', Auth::id())
                        ->count();
            $event = [
                'date' => $date->date->format('Y-m-d'),
                'name' => $date->client_event->name,
                'url' => $date->client_event->url,
                'icon' => $count > 0 ? "mdi-check-bold" : "mdi-minus",
            ];
            $result[$date->date->format('Y-m-d')][] = $event;
        }

        return [
                    'need' => true,
                    'dates' =>$result,
        ];
    }

}
