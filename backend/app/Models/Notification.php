<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user this notification belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notifiable entity (polymorphic)
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if notification is unread
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): bool
    {
        if ($this->isUnread()) {
            return $this->update(['read_at' => now()]);
        }

        return false;
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): bool
    {
        if (!$this->isUnread()) {
            return $this->update(['read_at' => null]);
        }

        return false;
    }
}
