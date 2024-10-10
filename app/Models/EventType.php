<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    // casts
    protected function casts(): array
    {
        return [
            'editable' => 'boolean',
        ];
    }

    protected $guarded = [
        'id'
    ];

}
