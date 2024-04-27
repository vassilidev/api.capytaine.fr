<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $fillable = [
        'extraction_id',
        'is_valid',
        'data',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'data'     => 'array',
    ];

    public function extraction(): BelongsTo
    {
        return $this->belongsTo(Extraction::class);
    }

    public function validate(): bool
    {
        return $this->update([
            'is_valid' => true,
        ]);
    }

    public function scopeValid(Builder $query, bool $valid = true): Builder
    {
        return $query->where('is_valid', $valid);
    }
}
