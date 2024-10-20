<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('ayumi:create-event-date')
    ->dailyAt('00:05');
Schedule::command('ayumi:screenshot-request')
    ->dailyAt('07:00');
Schedule::command('ayumi:event-information')
    ->dailyAt('18:00');
