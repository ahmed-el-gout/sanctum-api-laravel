<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:sanctum'])->name('dashboard');


// Route::post('/login', 'App\Http\controllers\Authcontroller@login');
// Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\controllers\UserController@login');
Route::post('/register', 'App\Http\controllers\UserController@register');
Route::get('/logout', 'App\Http\controllers\UserController@logout');
