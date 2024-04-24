<?php

namespace App\Services\Events;

use App\Models\Calendar;
use App\Models\Connector;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CalendarEventService
{
    public function getAllEventFromCalendar(Calendar $calendar): Collection
    {
        return Event::query()
            ->where(function (Builder $query) use ($calendar) {
                $query->where('eventable_type', Calendar::class)
                    ->where('eventable_id', $calendar->id);
            })
            ->orWhere(function (Builder $query) use ($calendar) {
                $query->where('eventable_type', Connector::class)
                    ->whereIn('eventable_id', $calendar->connectors()->pluck('id'));
            })
            ->get();
    }
}