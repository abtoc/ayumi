<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientEventDate extends Model
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
            'date' => 'date',
        ];
    }

    // Relation
    public function client_event(): BelongsTo
    {
        return $this->belongsTo(ClientEvent::class);
    }
    public function screenshots(): HasMany
    {
        return $this->hasMany(Screenshot::class);
    }
}
