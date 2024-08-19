<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

Route::fallback(function () {
    throw new HttpException('The request could not be understood or was missing required parameters');
});
