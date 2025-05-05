<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ContactController::class, 'index']);
Route::post('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');
Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth'])->name('admin');
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth'])->name('admin');
Route::get('/admin/{id}', [AdminController::class, 'show'])->middleware('auth')->name('admin.show');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->middleware('auth')->name('admin.destroy');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // 必要に応じて export ルートも定義
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
});