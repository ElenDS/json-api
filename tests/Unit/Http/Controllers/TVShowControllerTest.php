<?php

namespace Http\Controllers;

use App\Exceptions\ShowNameNotFoundException;
use App\Exceptions\TvShowApiRequestException;
use App\Services\TvShowService;
use App\Http\Controllers\TVShowController;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class TVShowControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @throws TvShowApiRequestException
     * @throws ShowNameNotFoundException
     */
    public function testNonCaseSensitiveRequest()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('query')
            ->with('q')
            ->andReturn('houSe');

        $service = new TvShowService($request->query('q'));
        $result = $service->searchTvShows();

        $this->assertEquals('House', $result['show']['name']);
    }

    /**
     * @throws TvShowApiRequestException
     * @throws ShowNameNotFoundException
     */
    public function testNonTypoTolerantRequest()
    {
        $this->expectException(ShowNameNotFoundException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('query')
            ->with('q')
            ->andReturn('hauSe');

        $service = new TvShowService($request->query('q'));
        $service->searchTvShows();
    }
}
