<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WorkController;

Route::get('/',[WorkController::class,"index"])->name('home');
Route::get('/works/{work}/note',[WorkController::class,"showNote"])->name('work.showNote');
Route::get('/works/{work}/workspace',[WorkController::class,"openWorkspace"])->name('workspace');
Route::put('/works/{work}/',[WorkController::class,'update'])->name('work.update');
Route::get('/works/create',[WorkController::class,'createWorkspace'])->name('work.create');
Route::post('/works',[WorkController::class,'store'])->name('work.store');
Route::get('/myWorks', [WorkController::class, 'myWorks'])->name('myWorks');
Route::put('/works/{work}',[WorkController::class,'togglePublic'])->name('work.publish');
Route::delete('/works/{work}', [WorkController::class, 'destroy'])->name('work.destroy');



Route::get('/works/myworks',[WorkController::class,'myWorks'])->name('work.myWorks');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
