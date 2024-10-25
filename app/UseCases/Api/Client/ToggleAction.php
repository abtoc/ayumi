<?php

namespace App\UseCases\Api\Client;

use App\Models\ClientEvent;
use App\Models\ClientEventDate;

class ToggleAction
{
    public function __invoke($id)
    {
        $event = ClientEvent::find($id);
        if(!is_null($event)){
            $event->delivered = !$event->delivered;
            $event->save();
            return ['value' => $event->delivered];
        }
        $date = ClientEventDate::find($id);
        if(!is_null($date)){
            $date->collected = !$date->collected;
            $date->save();
            return ['value' => $date->collected];
        }
        return ['value' => null];
    }
}
