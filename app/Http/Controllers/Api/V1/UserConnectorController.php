<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ConnectorResource;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class UserConnectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user): AnonymousResourceCollection
    {
        $connectors = $user->connectors;

        return ConnectorResource::collection($connectors);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexAuth(): AnonymousResourceCollection
    {
        $connectors = request()?->user()->connectors()->withCount('events')->get();

        return ConnectorResource::collection($connectors);
    }

    public function toggle(): JsonResponse
    {
        $result = request()->user()->connectors()->toggle(request('connector_id'));

        if ($result['attached']) {
            return response()->json([
                'message' => 'Connector attached',
            ]);
        }

        if ($result['detached']) {
            $calendarCount = DB::table('connectorables')
                ->where('connector_id', request('connector_id'))
                ->where('connectorable_type', Calendar::class)
                ->whereIn('connectorable_id', request()->user()->calendars->pluck('id'))
                ->delete();

            return response()->json([
                'message'        => 'Connector detached',
                'calendar_count' => $calendarCount,
            ]);
        }

        return response()->json([
            'message' => 'Error while attaching/detaching connector',
        ]);
    }
}
