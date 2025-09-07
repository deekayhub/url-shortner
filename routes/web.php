<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UrlShortnerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/shorten', [UrlShortnerController::class, 'shorten'])->name('shorten');
Route::get('/u/{code}', [UrlShortnerController::class, 'redirect'])->name('redirect');
