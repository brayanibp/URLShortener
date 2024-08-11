<?php

use App\Http\Controllers\URLShortenerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [URLShortenerController::class, 'index'])->name('home');

Route::get('/{shorten}', [URLShortenerController::class,'redirectToOriginalUrl'])->name('redirect');
