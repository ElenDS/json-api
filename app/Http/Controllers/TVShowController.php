<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TVShowController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        return response()->json(['show' => 'test']);
    }
}
