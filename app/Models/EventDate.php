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

    // casts
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'editable' => 'boolean',
        ];
    }

    // Relation
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function event_type(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }
}
