<?php

namespace App\Services\Events;

use App\Models\Calendar;
use App\Models\Connector;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

class CalendarEventService
{
    public function getAllEventFromCalendar(Calendar $calendar, array $params = []): Collection
    {
        return Event::query()
            ->with('eventable')
            ->where(function (Builder $query) use ($calendar) {
                $query->where(function (Builder $query) use ($calendar) {
                    $query->where('eventable_type', Connector::class)
                        ->whereIn('eventable_id', $calendar->connectors()->pluck('id'));
                })->orWhere(function (Builder $query) use ($calendar) {
                    $query->where('eventable_type', Calendar::class)
                        ->where('eventable_id', $calendar->id);
                });
            })
            ->when(isset($params['start_at']), function (Builder $query) use ($params) {
                $query->where('events.start_at', '>=', $params['start_at']);
            })
            ->when(isset($params['end_at']), function (Builder $query) use ($params) {
                $query->where('events.end_at', '<=', $params['end_at']);
            })
            ->when(true, function ($query) {
                logger($query->toSql(), $query->getBindings());
            })
            ->get();
    }
}