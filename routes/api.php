<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PostController;

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


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('jwt');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('jwt');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::prefix('posts')->middleware(['jwt', 'verified'])->group(function(){
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{id}/show', [PostController::class, 'show'])->name('posts.show');
    Route::put('/{id}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');
});

