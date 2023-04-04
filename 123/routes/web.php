<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test1ApiCont;
use App\Http\Controllers\test1Cont;

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

Route::get('/',[test1Cont::class, 'showLog']);
Route::post('/l',[test1Cont::class, 'showL'])->name('sL');
Route::post('/r', [test1Cont::class, 'showReg'])->name('sReg');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/welcome', [test1Cont::class, 'shw'])->name('shw');
    Route::get('/welcome/{test1Item}', [test1Cont::class, 'showUpd'])->name('showUpd');
    Route::post('/welcome', [test1Cont::class, 'add'])->name('add');
    Route::delete('/welcome{id}', [test1Cont::class, 'del'])->name('delete');
    Route::put('/welcome/{id}', [test1Cont::class, 'Upd'])->name('Upd');
});

require __DIR__.'/auth.php';

