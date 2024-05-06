<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ConnectorResource;
use App\Models\Connector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConnectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $connectors = Connector::query()
            ->withCount(['events', 'calendars'])
            ->when(request()->get('tags'), function (Builder $query) {
                $query->whereHas('tags', function (Builder $q) {
                    $q->whereIn('id', request()->get('tags'));
                });
            })
            ->when(request()->has('search'), function (Builder $query) {
                $query->where('name', 'like', '%' . request()->get('search') . '%');
            })
            ->when(request()->has('order_by'), function (Builder $query) {
                $query->orderBy(request()->get('order_by'), request()->get('order', 'asc'));
            })
            ->withCount(['tags', 'events'])
            ->get();

        return ConnectorResource::collection($connectors);
    }

    /**
     * Display the specified resource.
     */
    public function show(Connector $connector): ConnectorResource
    {
        return ConnectorResource::make($connector);
    }
}
