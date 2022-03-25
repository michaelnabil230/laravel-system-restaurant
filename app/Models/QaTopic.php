<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QaTopic extends Model
{
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'creator_id',
        'receiver_id',
        'sent_at',
    ];

    /**
     * Get all of the messages for the QaTopic
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(QaMessage::class, 'topic_id')->latest();
    }

    public static function unreadCount()
    {
        $topics = self::query()
            ->where(function ($query) {
                $query
                    ->where('creator_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->with('messages')
            ->latest()
            ->get();

        $unreadCount = 0;

        foreach ($topics as $topic) {
            foreach ($topic->messages as $message) {
                if ($message->sender_id !== auth()->id() && $message->read_at === null) {
                    ++$unreadCount;
                }
            }
        }

        return $unreadCount;
    }

    public function hasUnreads()
    {
        return $this->messages()->whereNull('read_at')->where('sender_id', '!=', auth()->id())->exists();
    }

    public function receiverOrCreator()
    {
        return $this->creator_id === auth()->id()
            ? User::withTrashed()->findOrFail($this->receiver_id)
            : User::withTrashed()->findOrFail($this->creator_id);
    }
}
