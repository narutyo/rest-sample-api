<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ResetPasswordController;

use App\Http\Controllers\API\Sample\RssController;
use App\Http\Controllers\API\Note\TemplateMasterController;

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

Route::middleware(['api', 'cors'])->group(function () {
  Route::post('/session/login', [LoginController::class, 'login']);
  Route::post('/password/forget', [ForgotPasswordController::class, 'sendResetLinkEmail']);
  Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

  Route::middleware('auth:sanctum')->group(function(){
    Route::put('/password/change', [ChangePasswordController::class, 'update']);

    Route::prefix('/session')->group(function () {
      Route::get("/user", [LoginController::class,'me']);
      Route::post("/logout", [LoginController::class,'logout']);
    });


    Route::prefix('/sample')->group(function () {
      Route::prefix('/rss')->group(function () {
        Route::get('', [RssController::class, 'index']);
      });
    });

    Route::prefix('/note')->group(function () {
      Route::prefix('/template')->group(function () {
        Route::get('', [TemplateMasterController::class, 'index']);
        Route::get('/{note_template}', [TemplateMasterController::class, 'show']);
        Route::post('', [TemplateMasterController::class, 'store']);
        Route::put('/{note_template}', [TemplateMasterController::class, 'update']);
        Route::delete('/{note_template}', [TemplateMasterController::class, 'destroy']);
      });
    });


  });
});
