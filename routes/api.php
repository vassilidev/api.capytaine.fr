<?php

use App\Http\Controllers\Api\V1\CalendarController;
use App\Http\Controllers\Api\V1\CalendarEventController;
use App\Http\Controllers\Api\V1\ConnectorController;
use App\Http\Controllers\Api\V1\Scraper\Run\ResultController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\UserConnectorController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'as'     => 'api.v1.',
], static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::apiResource('calendars', CalendarController::class);
        Route::apiResource('connectors', ConnectorController::class);
        Route::apiResource('calendars.events', CalendarEventController::class);
        Route::apiResource('users.connectors', UserConnectorController::class)->only('index');

        Route::get('users/connectors', [UserConnectorController::class, 'indexAuth']);
        Route::post('users/connectors/toggle', [UserConnectorController::class, 'toggle']);

        Route::apiResource('tags', TagController::class)->only(['index', 'show']);
    });

    Route::post('scrapers/{scraper}/runs/{run}/results', ResultController::class)
        ->name('scrapers.runs.results');
});