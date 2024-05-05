<?php

namespace App\Services\Events;

use App\Models\Calendar;
use App\Models\Connector;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CalendarEventService
{
    public function getAllEventFromCalendar(Calendar $calendar, array $params = []): Collection
    {
        $plan = Auth::user()->currentSubscription?->type;

        $maxDate = now()->addDay();

        if ($plan) {
            $nbrMaxDays = (int)(config()->get('plans.' . $plan . '.nbMaxDayEvent') ?? 7);

            $maxDate = now()->addDays($nbrMaxDays);
        }

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
            ->where(function (Builder $query) use ($maxDate, $params) {
                $query->where(function (Builder $query) use ($maxDate) {
                    $query
                        ->where('events.eventable_type', Connector::class)
                        ->where('events.start_at', '<=', $maxDate);
                })->orWhere(function (Builder $query) use ($maxDate) {
                    $query
                        ->where('events.eventable_type', Calendar::class)
                        ->where('events.start_at', '<=', $maxDate);
                })->when(isset($params['start_at']), function (Builder $query) use ($params) {
                    $query->where('events.start_at', '>=', $params['start_at']);
                });
            })
            //->when(Auth::user()->subscribed('individual'), function (Builder $query) use ($maxDate, $params) {
            //                $query->where(function (Builder $query) use ($maxDate) {
            //                    $query
            //                        ->where('events.eventable_type', Connector::class)
            //                        ->where('events.start_at', '<=', $maxDate);
            //                })->orWhere(function (Builder $query) use ($maxDate) {
            //                    $query
            //                        ->where('events.eventable_type', Calendar::class)
            //                        ->where('events.start_at', '<=', $maxDate);
            //                })->when(isset($params['start_at']), function (Builder $query) use ($params) {
            //                    $query->where('events.start_at', '>=', $params['start_at']);
            //                });
            //            })
            ->get();
    }
}