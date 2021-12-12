<?php

use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::get('/countries', [CountryController::class, 'index']);
Route::post('/country/add', [CountryController::class, 'store']);
Route::post('/country/edit/{id}', [CountryController::class, 'update']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/user/add', [UserController::class, 'store']);
Route::post('/user/edit/{id}', [UserController::class, 'update']);

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);

Route::get('/posts', [PostController::class, 'index']);
Route::post('/post/add', [PostController::class, 'store']);
Route::post('/post/edit/{id}', [PostController::class, 'update']);

Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comment/add', [CommentController::class, 'store']);
Route::post('/comment/edit/{id}', [CommentController::class, 'update']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
