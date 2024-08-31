<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Gemini関連
use App\Http\Controllers\ChatController;

Route::post('/chat', [ChatController::class, 'sendChat'])->name('chat.send');
Route::get('/chat/history', [ChatController::class, 'getHistory'])->name('chat.getHistory');