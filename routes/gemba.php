<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GEMBA\SampleController;
use App\Http\Controllers\GEMBA\RssSampleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sample', [SampleController::class, 'store']);

Route::get('/rss_sample', [RssSampleController::class, 'index']);
Route::post('/rss_sample', [RssSampleController::class, 'store']);
