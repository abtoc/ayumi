<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientEvent extends Model
{
    use HasFactory, HasUlids;

    // Relation
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // guarded
    protected $guarded = [
        'id'
    ];
}
