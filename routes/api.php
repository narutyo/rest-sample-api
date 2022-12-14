<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ResetPasswordController;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Sample\BusinessReportController;
use App\Http\Controllers\API\Note\TemplateMasterController;
use App\Http\Controllers\API\Note\AlignmentMasterController;

use App\Http\Controllers\GEMBA\SampleBusinessReportController;

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
  Route::post('/session/login', [AccessTokenController::class, 'issueToken']);
  Route::post('/password/forget', [ForgotPasswordController::class, 'sendResetLinkEmail']);
  Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

  Route::middleware('auth:api')->group(function(){
    Route::put('/password/change', [ChangePasswordController::class, 'update']);

    Route::prefix('/session')->group(function () {
      Route::get("/user", [LoginController::class,'me']);
      Route::post("/logout", [LoginController::class,'logout']);
    });

    Route::prefix('/users')->group(function () {
      Route::get('', [UserController::class, 'index']);
      Route::post('', [UserController::class, 'store']);
      Route::put('/{user}', [UserController::class, 'update']);
      Route::delete('/{user}', [UserController::class, 'delete']);
    });

    Route::prefix('/sample')->group(function () {
      Route::prefix('/business_report')->group(function () {
        Route::get('', [BusinessReportController::class, 'index']);
        Route::get('/aggregate', [BusinessReportController::class, 'aggregate']);
        Route::get('/suggest', [BusinessReportController::class, 'suggest']);
        Route::post('/generate', [BusinessReportController::class, 'generate']);
        Route::delete('/truncate', [BusinessReportController::class, 'truncate']);
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

      Route::prefix('/alignment')->group(function () {
        Route::get('', [AlignmentMasterController::class, 'index']);
        Route::get('/supply_info/{note_alignment}', [AlignmentMasterController::class, 'supply_info']);
        Route::get('/recordset/{note_alignment}', [AlignmentMasterController::class, 'recordset']);
        Route::get('/{note_alignment}', [AlignmentMasterController::class, 'show']);
        Route::post('', [AlignmentMasterController::class, 'store']);
        Route::put('/{note_alignment}', [AlignmentMasterController::class, 'update']);
        Route::delete('/{note_alignment}', [AlignmentMasterController::class, 'destroy']);
        Route::post('/callback', [AlignmentMasterController::class, 'callback']);
      });
    });
  });
});

Route::middleware(['api'])->prefix('/gemba')->group(function () {
  Route::middleware('auth:api')->group(function(){
    Route::prefix('/sample_business_report')->group(function () {
      Route::get('', [SampleBusinessReportController::class, 'index']);
      Route::get('/count', [SampleBusinessReportController::class, 'record_count']);
      Route::get('/names', [SampleBusinessReportController::class, 'names']);
      Route::get('/aggregate', [SampleBusinessReportController::class, 'aggregate']);
      Route::get('/{report}', [SampleBusinessReportController::class, 'find']);
      Route::post('', [SampleBusinessReportController::class, 'store']);
    });
  });

  Route::prefix('/status')->group(function () {
    Route::post('/{code}', function($code) {
      return response()->json(['keys' => [], 'records' => [], 'message' => '??????????????????????????????'], 200, ['Content-Type' => 'application/json']);
    });
  });

});
