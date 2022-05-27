<?php

use App\Http\Livewire\FrontPage;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
]], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('pages', function () {
        return view('admin.pages');
    })->name('pages');
});

Route::get('/{urlslug}', FrontPage::class);
Route::get('/', FrontPage::class);
