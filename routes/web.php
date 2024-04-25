<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin', '*');
header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
