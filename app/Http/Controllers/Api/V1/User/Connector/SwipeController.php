<?php

namespace App\Http\Controllers\Api\V1\User\Connector;

use App\Http\Controllers\Controller;
use App\Models\Connector;
use Illuminate\Http\Request;

class SwipeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // TODO: Handle filter, min max, order, etc.

        $connectors = Connector::query()
            ->latest('created_at')
            ->whereNotIn('id', $request->user()->connectors->pluck('id'))
            ->paginate(15);

        return response()->json($connectors);
    }
}
