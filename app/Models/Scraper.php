<?php

namespace App\Models;

use App\Actions\Scraper\RunScraper;
use App\Enums\Scraper\Method;
use App\Enums\Scraper\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Client\ConnectionException;

class Scraper extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

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

    public function run(): bool
    {
        return app(RunScraper::class)->execute($this);
    }

    public function extractions(): HasManyThrough
    {
        return $this->hasManyThrough(Extraction::class, Run::class);
    }
}
