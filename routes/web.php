<?php

use App\Http\Controllers\URLShortenerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [URLShortenerController::class, 'index'])->name('home');

Route::get('/add', [URLShortenerController::class, 'showAddForm'])->name('add-url');

Route::get('/{shorten}', [URLShortenerController::class,'redirectToOriginalUrl'])->name('redirect');
