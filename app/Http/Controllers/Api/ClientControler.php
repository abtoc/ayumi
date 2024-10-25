<?php

namespace App\Http\Controllers\Api;

use App\Models\ClientEvent;
use App\UseCases\Api\Client\ClientAction;
use App\UseCases\Api\Client\EventAction;
use App\UseCases\Api\Client\ToggleAction;
use Illuminate\Http\Request;

class ClientControler extends BaseController
{
    public function client(ClientAction $action)
    {
        return $this->sendResponse(
            'Client',
            $action(),
        );
    }

    public function event(ClientEvent $client_event, EventAction $action)
    {
        return $this->sendResponse(
            'Client',
            $action($client_event),
        );
    }

    public function toggle(string $id, ToggleAction $action)
    {
        return $this->sendResponse(
            'Client',
            $action($id),
        );
    }
}
