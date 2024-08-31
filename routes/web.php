<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WorkController;

Route::get('/',[WorkController::class,"index"])->name('home');
Route::post('/works',[WorkController::class,'store'])->name('work.store');
Route::get('/myWorks', [WorkController::class, 'myWorks'])->name('myWorks');
Route::get('/works/create',[WorkController::class,'createWorkspace'])->name('work.create');
Route::get('/works/myworks',[WorkController::class,'myWorks'])->name('work.myWorks');
Route::get('/works/{work}/note',[WorkController::class,"showNote"])->name('work.showNote');
Route::get('/works/{work}/workspace',[WorkController::class,"openWorkspace"])->name('workspace');
Route::put('/works/{work}/',[WorkController::class,'update'])->name('work.update');
Route::put('/works/{work}',[WorkController::class,'togglePublic'])->name('work.publish');
Route::delete('/works/{work}', [WorkController::class, 'destroy'])->name('work.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use Gemini\Laravel\Facades\Gemini;

Route::get('/gemini-test', function () {
    // Geminiを使用してコンテンツを生成
    $result = Gemini::geminiPro()->generateContent('日本語も対応しているの？');
    
    // 結果を表示
    return $result->text(); // Hello! How can I assist you today?
});


require __DIR__.'/auth.php';
