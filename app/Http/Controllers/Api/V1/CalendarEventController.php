<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EventResource;
use App\Models\Calendar;
use App\Models\Event;
use App\Services\Events\CalendarEventService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Calendar $calendar): AnonymousResourceCollection
    {
        $events = app(CalendarEventService::class)->getAllEventFromCalendar($calendar, $request->all());

        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
