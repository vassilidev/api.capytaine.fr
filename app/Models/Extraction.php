<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extraction extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $fillable = [
        'name',
        'connector_id',
        'source',
    ];

    protected $withCount = [
        'results',
    ];

    public function connector(): BelongsTo
    {
        return $this->belongsTo(Connector::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
