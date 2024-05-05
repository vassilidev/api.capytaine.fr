<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

Route::group([
    'middleware' => 'auth:sanctum',
], static function () {
    Route::get('/subscribe/{plan}/{period}', SubscribeController::class);
    Route::get('billing', static fn() => Auth::user()->redirectToBillingPortal(config('app.frontend_url') . '/account/billing'));
});