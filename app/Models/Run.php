<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $fillable = [
        'scraper_id',
        'status',
        'response',
        'request',
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'response'   => 'array',
        'request'    => 'array',
        'started_at' => 'datetime',
        'ended_at'   => 'datetime'
    ];

    public function scraper(): BelongsTo
    {
        return $this->belongsTo(Scraper::class);
    }

    public function extractions(): HasMany
    {
        return $this->hasMany(Extraction::class);
    }
}
