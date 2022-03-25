<?php

namespace App\Models;

use App\Models\User as Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'subject_id',
        'subject_type',
        'admin_id',
        'properties',
        'host',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'properties' => 'collection',
    ];

    /**
     * Get the admin that owns the AuditLog
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id', 'admin_id');
    }
}
