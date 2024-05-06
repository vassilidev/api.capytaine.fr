<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelLike\Traits\Likeable;

class News extends Model
{
    use Likeable,
        HasUuids,
        HasFactory,
        SoftDeletes;

    protected $appends = [
        'active_ago',
    ];

    protected $fillable = [
        'source_id',
        'title',
        'description',
        'url',
        'image',
        'active_at',
    ];

    protected $casts = [
        'active_at' => 'datetime',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function getActiveAgoAttribute(): string
    {
        return $this->active_at->diffForHumans();
    }
}
