<?php

namespace App\Http\Controllers;

use App\Exceptions\ShowNameNotFoundException;
use App\Exceptions\TvShowApiRequestException;
use App\Services\TvShowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class TVShowController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->query('q');
            $tvShowService = new TvShowService($query);
            $searchResult = $tvShowService->searchTvShows();

            return response()->json([$query => $searchResult]);
        } catch (TvShowApiRequestException|ShowNameNotFoundException $exception) {
            return $exception->toJsonResponse();
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
