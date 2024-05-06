<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LikeRequest;
use App\Models\News;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public static array $entities = [
        'news' => News::class,
    ];

    public function store(LikeRequest $request): Response
    {
        Auth::user()->like($request->getModel());

        return response()->noContent();
    }

    /**
     * @throws Exception
     */
    public function destroy(LikeRequest $request): Response
    {
        Auth::user()->unlike($request->getModel());

        return response()->noContent();
    }
}
