<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screenshot extends Model
{
    use HasFactory, HasUlids;

    // guarded
    protected $guarded = [
        'id'
    ];

    // Relation
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function client_event_date(): BelongsTo
    {
        return $this->belongsTo(ClientEvent::class);
    }
}
