<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Models\Book;
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
    Route::get('/',[BookController::class, 'index'])->name('/allbooks');
    Route::post('/create', [BookController::class, 'create']);
    Route::get('/show/{id}', [BookController::class, 'show']);   
    Route::put('/update/{id}', [BookController::class, 'update']);
    Route::delete('/destroy/{id}', [BookController::class, 'destroy']);
});
//end

Route::prefix('/authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('/allauthors');
    Route::get('/show/{id}', [AuthorController::class, 'show']);
    Route::get('/show/{id}/books', [AuthorController::class, 'showWithBooks']);// Show author with books
    Route::post('/create', [AuthorController::class, 'create']);
    Route::put('/update/{id}', [AuthorController::class, 'update']);
    Route::delete('/destroy/{id}', [AuthorController::class, 'destroy']);
});

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('/allusers');
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::post('/create', [UserController::class, 'create']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});