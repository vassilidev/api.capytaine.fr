<?php

namespace App\Http\Controllers\Api\V1\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwipeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $news = News::query()
            ->with('source:id,name')
            ->whereNotNull('image')
            ->where('active_at', '<=', now())
            ->whereDoesntHave('likers', function (Builder $query) {
                $query->where('user_id', Auth::id());
            })
            ->latest('created_at')
            ->paginate(20);

        return response()->json($news);
    }
}
