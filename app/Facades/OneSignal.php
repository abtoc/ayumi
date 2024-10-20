<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OneSignal extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'onesignal';
    }
}
