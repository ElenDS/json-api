<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\QueryValidationMiddleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class QueryValidationMiddlewareTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRequestWithValidQueryParameters()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('query')
            ->andReturn(['q' => 'wednesday']);

        $next = function () {
            return new Response('OK', 200);
        };

        $middleware = new QueryValidationMiddleware();

        $response = $middleware->handle($request, $next);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    public function testExceptionIfQueryIsEmpty()
    {
        $this->expectException(HttpResponseException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('query')
            ->with('q')
            ->andReturn(null);

        $next = function () {
            return new Response('OK', 200);
        };

        $middleware = new QueryValidationMiddleware();

        $middleware->handle($request, $next);
    }

    public function testExceptionIfThereAreAdditionalQueryParameters()
    {
        $this->expectException(HttpResponseException::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('query')
            ->andReturn(['q' => 'wednesday', 'extra' => 'value']);

        $next = function () {
            return new Response('OK', 200);
        };

        $middleware = new QueryValidationMiddleware();

        $middleware->handle($request, $next);
    }
}
