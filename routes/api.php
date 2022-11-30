<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ResetPasswordController;


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

    /*
    Route::prefix('/users')->group(function () {
      Route::get('', [UserController::class, 'index']);
      Route::get('/{user}', [UserController::class, 'show']);
      Route::post('', [UserController::class, 'store']);
      Route::put('/{user}', [UserController::class, 'update']);
    });
    */

  });
});
