<?php

namespace Services;

use App\Exceptions\ShowNameNotFoundException;
use App\Exceptions\TvShowApiRequestException;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Redis;
use App\Services\TvShowService;
use Illuminate\Support\Facades\Http;
use Mockery;

class TvShowServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @throws TvShowApiRequestException
     * @throws ShowNameNotFoundException
     */
    public function testReturnsCachedDataIfExists()
    {
        $query = 'wednesday';
        $cacheKey = 'tv_shows_search_' . strtolower($query);
        $cachedResponse = [
            'show' => ['name' => 'Wednesday']
        ];

        Redis::shouldReceive('exists')
            ->once()
            ->with($cacheKey)
            ->andReturn(true);

        Redis::shouldReceive('get')
            ->once()
            ->with($cacheKey)
            ->andReturn(json_encode($cachedResponse));

        $service = new TvShowService($query);
        $result = $service->searchTvShows();

        $this->assertEquals($cachedResponse, $result);
    }

    /**
     * @throws TvShowApiRequestException
     * @throws ShowNameNotFoundException
     */
    public function testMakesApiRequestIfNoCache()
    {
        $query = 'wednesday';
        $cacheKey = 'tv_shows_search_' . strtolower($query);
        $apiResponse = [
            ['show' => ['name' => 'Wednesday']]
        ];

        Redis::shouldReceive('exists')
            ->once()
            ->with($cacheKey)
            ->andReturn(false);

        Http::fake(function () use ($apiResponse) {
            return Http::response($apiResponse, 200);
        });

        Redis::shouldReceive('setex')
            ->once()
            ->with($cacheKey, 3600, json_encode($apiResponse[0]))
            ->andReturn(true);

        $service = new TvShowService($query);
        $result = $service->searchTvShows();

        $this->assertEquals($apiResponse[0], $result);
    }

    /**
     * @throws TvShowApiRequestException
     */
    public function testThrowsExceptionIfShowNotFound()
    {
        $this->expectException(ShowNameNotFoundException::class);

        $query = 'non-existent show';
        $cacheKey = 'tv_shows_search_' . strtolower($query);
        $apiResponse = [
            ['show' => ['name' => 'Wednesdayy']]
        ];

        Redis::shouldReceive('exists')
            ->once()
            ->with($cacheKey)
            ->andReturn(false);

        Http::fake(function () use ($apiResponse) {
            return Http::response($apiResponse, 200);
        });

        $service = new TvShowService($query);
        $service->searchTvShows();
    }
}
