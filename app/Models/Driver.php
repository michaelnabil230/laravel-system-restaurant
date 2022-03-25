<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use Auditable;

    /**
     * The attributes that are mass searchable.
     *
     * @var array
     */
    public static $searchable = [
        'name',
        'phone'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'note'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone' => 'array',
    ];
}
