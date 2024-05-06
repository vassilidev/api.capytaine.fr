<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Calendar\NewsResource;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $preset = $request->get('preset', 'latest');

        $news = News::query()
            ->with('source:id,name')
            ->whereNotNull('image')
            ->when($request->get('search'), function (Builder $query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })
            ->when($request->get('active_at'), function (Builder $query) {
                $query->whereDate('active_at', request('active_at'));
            })
            ->when($preset === 'latest', function (Builder $query) {
                $query->latest('active_at');
            })
            ->when($preset === 'like', function (Builder $query) {
                $query->whereHas('likers', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                });
            })
            ->when($preset === 'connectors', function (Builder $query) {
                $query->whereHas('source', function (Builder $query) {
                    $query->whereHas('tags', function (Builder $query) {
                        $query->whereIn('id', Auth::user()->tags()->pluck('tags.id'));
                    });
                });
            })
            ->when($preset === 'random', function (Builder $query) {
                $query->inRandomOrder();
            })
            ->where('active_at', '<=', now())
            ->paginate(30);

        $news = Auth::user()->attachLikeStatus($news);

        return response()->json($news);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }
}
