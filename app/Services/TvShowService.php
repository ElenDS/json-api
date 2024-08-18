<?php

namespace App\Services;

use App\Exceptions\ShowNameNotFoundException;
use App\Exceptions\TvShowApiRequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class TvShowService
{
    protected string $apiUrl = 'https://api.tvmaze.com/search/shows';

    protected string $query;

    public function __construct(string $query)
    {
        $this->query = strtolower($query);
    }

    /**
     * @throws TvShowApiRequestException
     * @throws ShowNameNotFoundException
     */
    public function searchTvShows(): array
    {
        $cacheKey = 'tv_shows_search_' . $this->query;

        $response = Http::get($this->apiUrl, ['q' => $this->query]);

        if ($response->successful()) {
            $data = $response->json();

            return $this->processResponse($data);
        } else {
            throw new TvShowApiRequestException();
        }
    }

    /**
     * @throws ShowNameNotFoundException
     */
    protected function processResponse(array $data): array
    {
        $showData = array_filter(
            $data,
            function ($show) {
                return strtolower($show['show']['name']) === $this->query;
            }
        );

        if (count($showData) === 0) {
            throw new ShowNameNotFoundException();
        }

        return $showData[0];
    }

}
