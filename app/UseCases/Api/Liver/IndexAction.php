<?php

namespace App\UseCases\Api\Liver;

use App\Models\Liver;

class IndexAction
{
    public function __invoke()
    {
        $result = [];

        $livers = Liver::query()
                    ->orderBy('name', 'asc')
                    ->get();
        foreach ($livers as $liver) {
            $events = $liver->events()
                        ->where('start_on', '<=', today())
                        ->where('end_on', '>=', today())
                        ->orderBy('start_on', 'asc')
                        ->get();
            $result[] = [
                'name' => $liver->name,
                'url' => $liver->url,
                'events' => $events
                                ->map(fn ($event) => [
                                    'name' => $event->name,
                                    'url' => $event->url,
                                    'start_on' => $event->start_on->isoFormat('MM/DD(ddd)'),
                                    'end_on' => $event->end_on->isoFormat('MM/DD(ddd)'),
                                ])
                                ->toArray(),
            ];
        }

        return $result;
    }
}
