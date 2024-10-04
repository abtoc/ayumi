<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liver extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    /**
     * URLの取得
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => 'https://mixch.tv/u/'.$attribute['mixch_id'],
        );
    }
}
