<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WorkController;

Route::get('/', function () {
     return Inertia::render('Welcome', [
         'canLogin' => Route::has('login'),
         'canRegister' => Route::has('register'),
         'laravelVersion' => Application::VERSION,
         'phpVersion' => PHP_VERSION,
     ]);
 });
Route::get('/home',[WorkController::class,"index"])->name('home');
Route::get('/works/{work}/note',[WorkController::class,"showNote"])->name('work.showNote');
Route::get('/works/{work}/workspace',[WorkController::class,"openWorkspace"])->name('workspace');
Route::put('/notes/{work}/note',[WorkController::class,'update'])->name('work.update');
Route::get('/works/create',[WorkController::class,'createWorkspace'])->name('work.create');
Route::post('/works',[WorkController::class,'store'])->name('work.store');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
