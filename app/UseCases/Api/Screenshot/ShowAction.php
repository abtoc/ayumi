<?php

namespace App\UseCases\Api\Screenshot;

use App\Models\ClientEventDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShowAction
{
    public function __invoke(array $input)
    {
        $result = [
            'events' => [],
            'screenshots' => [],
        ];

        $date = Carbon::today();
        if(array_key_exists('date', $input)){
            $date = new Carbon($input['date']);
        }
        $result['date'] = $date->format('Y-m-d');

        $dates = ClientEventDate::query()
                    ->where('date', $date)
                    ->get();

        foreach ($dates as $date) {
            array_push($result['events'], [
                'title' => $date->client_event->name,
                'value' => $date->id,
            ]);
            $screenshots = $date->screenshots()
                                ->where('user_id', Auth::id())
                                ->get();
            foreach ($screenshots as $screenshot){
                array_push($result['screenshots'], [
                    'id' => $screenshot->id,
                    'name' => $date->client_event->name,
                    'url' => $screenshot->url,
                ]);
            }
        }
        return $result;
    }
}
