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
        'name', 'phone'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'note'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
    ];
}
