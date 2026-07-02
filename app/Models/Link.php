<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'original_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    public function getShortUrlAttribute(): string
    {
        return url('/'.$this->code);
    }

    public function getClicksCountAttribute(): int
    {
        return $this->clicks()->count();
    }
}
