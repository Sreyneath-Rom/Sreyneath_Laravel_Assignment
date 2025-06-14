<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//book route
Route::prefix('/books')->group(function(){
    Route::get('/',[BookController::class, 'index']);
    Route::get('/show/{id}', [BookController::class, 'show']);   
    Route::post('/store', [BookController::class, 'store']);
    Route::put('/update/{id}', [BookController::class, 'update']);
    Route::delete('/destroy/{id}', [BookController::class, 'destroy']);
});

//end
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});