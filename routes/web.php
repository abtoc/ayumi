<?php

use App\Models\Client;
use App\Models\ClientEvent;
use App\Models\ClientEventDate;
use Illuminate\Support\Facades\Route;

Route::get("/c/{client}", function (Client $client) {
    return view('client', ['client' => $client]);
})->name('client');
Route::get('/e/{client_event}', function (ClientEvent $client_event){
    return view('event', ['event' => $client_event]);
})->name('event');
Route::get('/d/{client_event_date}', function(ClientEventDate $client_event_date){
    return view('date', ['date' => $client_event_date]);
})->name('date');

Route::get('/{any?}', function () {
    return view('index');
});
