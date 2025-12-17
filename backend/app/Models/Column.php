<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Column extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'name',
        'position',
        'color',
        'limit',
    ];

    protected $casts = [
        'position' => 'integer',
        'limit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the board this column belongs to
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get all tasks in the column
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

    /**
     * Check if column has reached its WIP limit
     */
    public function isAtLimit(): bool
    {
        if (is_null($this->limit)) {
            return false;
        }

        return $this->tasks()->count() >= $this->limit;
    }
}
