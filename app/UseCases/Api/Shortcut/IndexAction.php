<?php

namespace App\UseCases\Api\Shortcut;

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
                    ->where('delivered', true)
                    ->count();

        // 未納品がなければ、スクショは不要
        if($count == 0){
            return [
                'need' => false,
                'dates' => [],
            ];
        }


        $dates = ClientEventDate::query()
                    ->join('client_events', 'client_event_dates.client_event_id', '=', 'client_events.id')
                    ->where('delivered', false)
                    ->where('collected', false)
                    ->orderBy('date', 'asc')
                    ->get();
        foreach ($dates as $date) {
            $count = $date->screenshots()
                        ->where('user_id', Auth::id())
                        ->count();
            if ($count == 0){
                if(!array_key_exists($date->date->format('Y-m-d'), $result)){
                    $result[$date->date->format('Y-m-d')] = [];
                }
                $event = [
                    'name' => $date->client_event->event_name.'('.$date->client_event->liver_name.')',
                    'url' => $date->client_event->url,
                ];
                $result[$date->date->format('Y-m-d')][] = $event;
            }
        }

        return [
                    'need' => true,
                    'dates' =>$result,
        ];
    }

}
