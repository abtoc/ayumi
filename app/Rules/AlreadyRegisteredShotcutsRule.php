<?php

namespace App\Rules;

use App\Models\ClientEvent;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlreadyRegisteredShotcutsRule implements ValidationRule
{
    private $event;


    public function __construct__(ClientEvent $event){
        $this->event = $event;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(is_null($this->event)) { return; }
        $dates = $this->event->client_event_dates()->where('date', '<', $value);
        foreach($dates as $date) {
            if($date->client_event_dates()->count() > 0){
                $fail('このイベントはすでにスクリーンショットがアップロードされたます、');
                return;
            }
        }
    }
}
