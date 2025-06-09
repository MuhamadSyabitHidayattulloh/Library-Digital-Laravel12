<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'approved_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'approved_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && now()->gt($this->return_date);
    }

    public function canBeReturned(): bool
    {
        return in_array($this->status, ['borrowed', 'overdue']);
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->return_date);
    }

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->status === 'borrowed') {
            return 0;
        }
        return now()->diffInDays($this->return_date, false);
    }

    protected static function booted()
    {
        static::saving(function ($borrow) {
            if ($borrow->status === 'borrowed' && $borrow->return_date->lt(now())) {
                $borrow->status = 'overdue';
            }
        });
    }
}
