<?php

namespace App\UseCases\Api\Client;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientAction
{
    public function __invoke()
    {
        $result = [];
        $clients = Client::query()
                    ->where('user_id', Auth::id())
                    ->where('updated_at', '>=', now()->subDays(180))
                    ->get();
        foreach ($clients as $client) {
            $result[] = [
                'id' => $client->id,
                'name' => $client->name,
                'url' => route('client', ['client' => $client]),
                'events' => $client->client_events()
                                ->orderBy('end_on', 'desc')
                                ->get()
                                ->map(fn ($event) => [
                                    'id' => $event->id,
                                    'name' => $event->name,
                                    'delivered' => $event->delivered,
                                    'url' => route('event', ['client_event'=> $event->id]),
                                    'start_on' => $event->start_on->format('m/d'),
                                    'end_on' => $event->end_on->format('m/d'),
                                ])->toArray(),
            ];
        }
        return $result;
    }
}
