<?php

use App\Http\Controllers\Api\V1\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], static function () {
    Route::apiResource('calendars', CalendarController::class);
});