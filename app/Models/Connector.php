<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connector extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

    protected $appends = [
        'primary_tag'
    ];

    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function calendars(): MorphToMany
    {
        return $this->morphedByMany(Calendar::class, 'connectorable');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'connectorable');
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
