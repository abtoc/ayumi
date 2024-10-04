<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    // guarded
    protected $guarded = [
        'id'
    ];

    /**
     * URLの取得
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => 'https://mixch.tv/live/event/'.$attribute['mixch_id'].'#about',
        );
    }

    // Relation
    public function event_dates(): HasMany
    {
        return $this->hasMany(EventDate::class);
    }
    public function livers(): BelongsToMany
    {
        return $this->belongsToMany(Liver::class);
    }

    // Event
    protected static function booted(): void
    {
        static::created(function ($event)
        {
            $event_first_type = EventType::where('name', '初日')->firstOrFail();
            EventDate::create([
                'event_id' => $event->id,
                'event_type_id' => $event_first_type->id,
                'date' => $event->start_at,
                'editable' => $event_first_type->editable,
                'created_at' => now(),
            ]);
            $event_last_type = EventType::where('name', '最終日')->firstOrFail();
            EventDate::create([
                'event_id' => $event->id,
                'event_type_id' => $event_last_type->id,
                'date' => $event->end_at,
                'editable' => $event_first_type->editable,
                'created_at' => now(),
            ]);
        });
        static::updated(function ($event)
        {
            if($event->isDirty('start_at')){
                $event_type = EventType::where('name', '初日')->firstOrFail();
                EventDate::where('event_id', $event->id)->where('event_type_id', $event_type->id)
                    ->update(['date' => $event->start_at, 'updated_at' => now()]);
            }
            if($event->isDirty('end_at')){
                $event_type = EventType::where('name', '最終日')->firstOrFail();
                EventDate::where('event_id', $event->id)->where('event_type_id', $event_type->id)
                    ->update(['date' => $event->end_at, 'updated_at' => now()]);
            }
        });
    }
}
