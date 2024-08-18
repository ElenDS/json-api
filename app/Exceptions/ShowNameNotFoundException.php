<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ShowNameNotFoundException extends Exception
{
    protected $message = 'The expected show name is missing in the API response';

    public function toJsonResponse(): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], 404);
    }
}
