<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Calendar\StoreCalendarRequest;
use App\Http\Resources\Api\V1\CalendarResource;
use App\Models\Calendar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CalendarResource::collection(
            Calendar::query()
                ->whereBelongsTo(auth()->user())
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalendarRequest $request): CalendarResource
    {
        $calendar = $request->user()->calendars()->create([
            'name' => $request->get('name'),
        ]);

        $calendar->connectors()->sync($request->get('connectors', []));

        return CalendarResource::make($calendar);
    }

    /**
     * Display the specified resource.
     */
    public function show(Calendar $calendar): CalendarResource
    {
        $calendar->load('connectors:id');

        return new CalendarResource($calendar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calendar $calendar): CalendarResource
    {
        $connectorsIds = $request->get('connectors', []);

        $calendar->connectors()->sync($connectorsIds);

        $calendar->load('connectors');

        return CalendarResource::make($calendar);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calendar $calendar)
    {

    }
}
