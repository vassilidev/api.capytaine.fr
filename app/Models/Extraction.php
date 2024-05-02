<?php

namespace App\Models;

use App\Actions\Extraction\ResetResults;
use App\Actions\PublishExtractionResults;
use App\Observers\ExtractionObserver;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ExtractionObserver::class)]
class Extraction extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes;

    protected array $cascadeDeletes = ['results'];

    protected $fillable = [
        'run_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $withCount = [
        'results',
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(Run::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function resetResults(bool $withNotification = false): int
    {
        return app(ResetResults::class)->execute($this, $withNotification);
    }

    public function publish(bool $withNotification = false): int
    {
        return app(PublishExtractionResults::class)->execute($this, $withNotification);
    }
}
