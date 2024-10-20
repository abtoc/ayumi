<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientEvent extends Model
{
    use HasFactory, HasUlids;

    // guarded
    protected $guarded = [
        'id'
    ];

    // casts
    protected function casts(): array
    {
        return [
            'delivered' => 'boolean',
            'start_on' => 'date',
            'end_on' => 'date',
        ];
    }

    // Relation
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function client_event_dates(): HasMany
    {
        return $this->hasMany(ClientEventDate::class);
    }

    // accessor
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['event_name'].'('.$attribute['liver_name'].')',
        );
    }

    // Event
    protected static function booted(): void
    {
        static::created(function ($event)
        {
            if($event->start_on->eq(today())){
                $event->client_event_dates()->create(['date' => $event->start_on]);
            }
        });
        static::deleting(function ($event){
            $event->client_event_dates()->delete();
        });
    }
}
