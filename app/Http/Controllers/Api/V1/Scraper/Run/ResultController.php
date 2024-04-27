<?php

namespace App\Http\Controllers\Api\V1\Scraper\Run;

use App\Enums\Run\Status;
use App\Http\Controllers\Controller;
use App\Models\Run;
use App\Models\Scraper;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __invoke(Request $request, Scraper $scraper, Run $run)
    {
        $run->end();

        $events = $request->input('events', []);

        $run->extraction()->create([
            'data' => $events,
        ]);

        return response()->json([
            'message' => count($events) . ' events were extracted',
        ]);
    }
}
