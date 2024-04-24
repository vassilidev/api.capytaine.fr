<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'is_all_day',
    ];

    protected $casts = [
        'start_at'   => 'datetime',
        'end_at'     => 'datetime',
        'is_all_day' => 'boolean',
    ];

    protected $appends = [
        'color',
    ];

    public function eventable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeAllDay(Builder $query, bool $isAllDay = true): Builder
    {
        return $query->whereIsAllDay($isAllDay);
    }

    protected function color(): Attribute
    {
        return Attribute::get(
            get: function () {
                return $this->eventable->color;
            },
        );
    }
}
