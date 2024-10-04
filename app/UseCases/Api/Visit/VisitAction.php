<?php

namespace App\UseCases\Api\Visit;

use App\Models\EventDate;
use Carbon\Carbon;

class VisitAction
{

    public function __invoke(array $input)
    {
        $result = [];

        /**
         * 日付を取り出す。存在しなければ、今日の日付を設定する。
         */
        $date = array_key_exists('date', $input) ? new Carbon($input['date']) : today();
        $result['date'] = $date->format('Y-m-d');

        /**
         * 指定した日付の日程を取り出す
         */
        $dates_org = EventDate::query()
            ->join('event_types', 'event_dates.event_type_id', '=', 'event_types.id')
            ->where('date', $date)
            ->orderBy('order', 'asc')
            ->get();

        $dates = collect([]);
        $dates_org->each(function ($date) use($dates) {
            if(in_array($date->name, ['初日', '最終日'], true)){
                $dates->push($date);
            } else {
                // 同イベントで同じ日程のものが登録済であれば、登録しない
                $first = $dates->first(fn ($item, $key) => $item->event_id === $date->event_id);
                if(is_null($first)){
                    $dates->push($date);
                } else {
                    $first->name = $first->name.'・'.$date->name;
                }
            }
        });

        $events = $dates->map(function ($date) {
            $event = $date->event;
            $livers = $event->livers->map(function ($liver) {
                return [
                    'name' => $liver->name,
                    'url' => $liver->url,
                ];
            });
            return [
                'title' => $date->name.':'.$event->name,
                'url' => $event->url,
                'livers' => $livers->toArray(),
            ];
        });

        $result['events'] = $events->toArray();

        return $result;
    }
}
