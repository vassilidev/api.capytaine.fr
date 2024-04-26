<?php

namespace App\Models;

use App\Enums\Scraper\Method;
use App\Enums\Scraper\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scraper extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $withCount = ['extractions'];

    protected $fillable = [
        'name',
        'description',
        'method',
        'type',
        'url',
        'headers',
        'connector_id'
    ];

    protected $casts = [
        'method'  => Method::class,
        'type'    => Type::class,
        'headers' => 'array'
    ];

    public function scopeMethod(Builder $query, Method $method = Method::GET): Builder
    {
        return $query->where('method', $method);
    }

    public function scopeType(Builder $query, Type $type = Type::WEBHOOK): Builder
    {
        return $query->where('type', $type);
    }

    public function connector(): BelongsTo
    {
        return $this->belongsTo(Connector::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(Run::class);
    }
}
