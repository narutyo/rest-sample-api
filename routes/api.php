<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\SampleController;
use App\Http\Controllers\API\RssSampleController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sample', [SampleController::class, 'store']);

Route::get('/rss_sample', [RssSampleController::class, 'index']);
Route::post('/rss_sample', [RssSampleController::class, 'store']);
