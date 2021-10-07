<?php

namespace App\Models;

use App\Models\User;
use App\Models\QaTopic;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QaMessage extends Model
{
    use Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id',
        'sender_id',
        'content',
        'read_at',
    ];

    protected $dates = [
        'sent_at',
    ];

    /**
     * Get the topic that owns the QaMessage
     *
     * @return BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(QaTopic::class);
    }

    /**
     * Get the sender associated with the QaMessage
     *
     * @return HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id')->withTrashed();
    }
}
