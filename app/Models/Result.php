<?php

namespace App\Models;

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
    ];

    public function extraction(): BelongsTo
    {
        return $this->belongsTo(Extraction::class);
    }
}
