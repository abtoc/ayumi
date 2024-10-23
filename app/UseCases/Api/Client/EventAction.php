<?php

namespace App\UseCases\Api\Client;

use App\Models\ClientEvent;
use App\Models\User;

class EventAction
{
    public function __invoke(ClientEvent $event)
    {
        $result = [
            'id' => $event->id,
            'name' => $event->name,
            'delivered' => $event->delivered,
            'url' => route('event', ['client_event', $event]),
            'dates' => [],
        ];

        $dates = $event->client_event_dates()
            ->orderBy('date', 'desc')
            ->get();
        foreach($dates as $date){
            $ids = $date->screenshots()
                    ->select('user_id')
                    ->get();
            $no_submitted =  User::query()
                    ->whereNotIn('id', $ids->toArray());
            $result['dates'][] = [
                'id' => $date->id,
                'date' => $date->date->format('Y/m/d'),
                'collected' => $date->collected,
                'no_submitted' => $no_submitted->count() > 0 && $date->collected === false ? $no_submitted->get()->pluck('name')->join(',') : null,
                'url' => route('date', ['client_event_date' => $date]),
            ];
        }

        return $result;
    }
}
