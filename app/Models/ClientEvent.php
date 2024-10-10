<?php

namespace App\Models;

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
}
