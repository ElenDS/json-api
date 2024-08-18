<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TvShowApiRequestException extends Exception
{
    protected $message = 'Failed to connect to the TV service API';

    public function toJsonResponse(): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], 404);
    }
}
