<?php

use App\Http\Controllers\URLShortenerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

Route::post("/generate-short-url",[URLShortenerController::class, 'generateShortUrl']);

Route::get('/{shortUrl}', [URLShortenerController::class, 'redirectToOriginalUrl']);

Route::delete('/{shortUrl}', [URLShortenerController::class, 'removeShortenedUrl']);
