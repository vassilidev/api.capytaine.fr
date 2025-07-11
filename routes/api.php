<?php

use App\Http\Controllers\Api\V1\AuthUserController;
use App\Http\Controllers\Api\V1\CalendarController;
use App\Http\Controllers\Api\V1\CalendarEventController;
use App\Http\Controllers\Api\V1\ConnectorController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\Scraper\Run\ResultController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\User\Connector\BillingController;
use App\Http\Controllers\Api\V1\User\Connector\SwipeController;
use App\Http\Controllers\Api\V1\UserConnectorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', [AuthUserController::class, 'show']);

Route::group([
    'prefix' => 'v1',
    'as'     => 'api.v1.',
], static function () {
    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::apiResource('calendars', CalendarController::class);
        Route::apiResource('connectors', ConnectorController::class);
        Route::apiResource('calendars.events', CalendarEventController::class);
        Route::apiResource('users.connectors', UserConnectorController::class)->only('index');
        Route::apiResource('news', NewsController::class);

        Route::get('swipe/news', \App\Http\Controllers\Api\V1\News\SwipeController::class);

        Route::get('users/connectors', [UserConnectorController::class, 'indexAuth']);
        Route::get('users/connectors/swipe', SwipeController::class);
        Route::post('users/connectors/toggle', [UserConnectorController::class, 'toggle']);

        Route::apiResource('tags', TagController::class)->only(['index', 'show']);

        Route::get('billing', BillingController::class);

        Route::controller(AuthUserController::class)->group(static function () {
            Route::put('user', 'update');
        });

        Route::controller(LikeController::class)->group(static function () {
            Route::post('like', 'store');
            Route::delete('like', 'destroy');
        });
    });

    Route::post('scrapers/{scraper}/runs/{run}/results', ResultController::class)
        ->name('scrapers.runs.results');
});