<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name', 'phone', 'note'
    ];
    protected $casts = [
        'phone' => 'array',
    ];
}
