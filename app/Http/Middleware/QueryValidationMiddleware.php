<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->query('q')) || count($request->query()) > 1) {
            throw new HttpResponseException(response()->json(['error' => 'Invalid query parameters'], 400));
        }
        return $next($request);
    }
}
