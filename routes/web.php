<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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

Route::get('/', function () {
    return view('user_details');
});

Route::post('/store', [WebController::class, 'store'])->name('store');
Route::post('/delete', [WebController::class, 'delete'])->name('delete');
Route::get('/edit', [WebController::class, 'edit'])->name('edit');
Route::get('/get_data', [WebController::class, 'get_data'])->name('get_data');
Route::post('/update', [WebController::class, 'update'])->name('update');
