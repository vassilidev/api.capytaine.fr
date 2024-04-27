<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Connector;

class Event extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'is_all_day',
        'eventable_id',
        'eventable_type',
    ];

    protected $casts = [
        'start_at'   => 'datetime',
        'end_at'     => 'datetime',
        'is_all_day' => 'boolean',
    ];

    public function eventable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getEventableName(): string
    {
        $typeParams = [
            Connector::class => [
                'name'  => 'name',
                'label' => 'Connector',
            ],
            Calendar::class  => [
                'name'  => 'name',
                'label' => 'Calendar',
            ],
        ];

        $type = $this->eventable_type;

        $params = optional($typeParams[$type]);

        return $params['label'] . ' - ' . $this->eventable?->{$typeParams[$type]['name']};
    }

    public function scopeAllDay(Builder $query, bool $isAllDay = true): Builder
    {
        return $query->whereIsAllDay($isAllDay);
    }
}
