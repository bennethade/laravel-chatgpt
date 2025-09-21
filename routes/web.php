<?php

use App\Http\Controllers\ChatGptDestroyController;
use App\Http\Controllers\ChatGptIndexController;
use App\Http\Controllers\ChatGptStoreController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function(){
    Route::get('/chat/{id?}', ChatGptIndexController::class)->name('chat.show');
    Route::post('/chat/{id?}', ChatGptStoreController::class)->name('chat.store');
    Route::delete('/chat/{chat}', ChatGptDestroyController::class)->name('chat.destroy');
});




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
