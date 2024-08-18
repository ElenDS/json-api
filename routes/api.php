<?php

use App\Http\Controllers\TVShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TVShowController::class, 'search'])->middleware('validate.query');
