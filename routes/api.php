<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/tags', [TestController::class, 'test']);
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/create', [TagController::class, 'store']);
    Route::post('/edit', [TagController::class, 'update']);
    Route::post('/delete', [TagController::class, 'destroy']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/create', [CategoryController::class, 'store']);
    Route::post('/upload', [CategoryController::class, 'upload']);
    Route::post('/img_delete', [CategoryController::class, 'deleteImage']);
});
Route::middleware('auth:api')->group(function () {
    

    
});
