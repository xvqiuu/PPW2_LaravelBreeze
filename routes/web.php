<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[BukuController::class,'index'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('admin')->group(function () {

        Route::get('/buku/create',[BukuController::class,'create'])->name('buku.create');
        Route::post('/buku',[BukuController::class,'store'])->name('buku.store');

        Route::post('/buku/delete/{id}',[BukuController::class,'destroy'])->name('buku.destroy');

        Route::get('/buku/edit/{id}',[BukuController::class,'edit'])->name('buku.edit');
        Route::post('/buku/{id}/edit', [BukuController::class,'update'])->name('buku.update');

        Route::get('/gallery/delete/{id}', [BukuController::class, 'deleteGallery'])->name('buku.deleteGallery');

        Route::get('/detail-buku/{title}',  [BukuController::class,'galbuku']) -> name('galeri.buku');

    });
    Route::get('/buku',[BukuController::class,'index']);

    Route::get('/buku/search',[BukuController::class,'search'])->name('buku.search');

    Route::get('/buku/{id}/detail', [BukuController::class, 'showDetail'])->name('buku.detail');

    Route::get('/buku/{id}/myfavourite', [BukuController::class,'addToFavourite'])->name('buku.addToFavourite');
    Route::get('/buku/myfavourite', [BukuController::class,'showFavourite'])-> name('buku.myfavourite');

    Route::post('/buku/{id}/rating', [BukuController::class,'addRating'])->name('buku.rating');

});

require __DIR__.'/auth.php';
