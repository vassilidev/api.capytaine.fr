<?php

namespace App\Models;

use App\Actions\Source\ExtractRSS;
use App\Jobs\ExtractRssSource;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use FeedException;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'url',
        'logo',
        'description',
        'rss',
        'last_extracted_at',
    ];

    protected $appends = [
        'primary_tag'
    ];

    protected $casts = [
        'last_extracted_at' => 'datetime',
    ];

    protected array $cascadeDeletes = ['news'];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * @throws FeedException
     */
    public function extract(bool $withNotification = false, bool $sync = true)
    {
        if (!$sync) {
            return ExtractRssSource::dispatch($this);
        }

        return app(ExtractRSS::class)->execute($this, withNotification: $withNotification);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')
            ->withPivot([
                'is_primary'
            ]);
    }

    public function primaryTag()
    {
        return $this->tags()
            ->wherePivot('is_primary', true)
            ->first();
    }

    public function getPrimaryTagAttribute()
    {
        return $this->primaryTag()?->id ?? null;
    }
}
