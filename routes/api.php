<?php

use App\Http\Controllers\TVShowController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

Route::get('/', [TVShowController::class, 'search'])->middleware('validate.query');

Route::fallback(function () {
    return new JsonResponse([
        'error' => 'The request could not be understood or was missing required parameters'
    ], 400);
});
