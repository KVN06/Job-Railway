<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name'),
        'version' => app()->version(),
        'status' => 'OK',
    ]);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found.',
    ], 404);
});
