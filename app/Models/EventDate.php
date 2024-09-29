<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDate extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    // Relation
    public function event(): BelongsTo
    {
        return $this->berlongsTo(Event::class);
    }
    public function event_type(): BelongsTo
    {
        return $this->berlongsTo(EventType::class);
    }
}
