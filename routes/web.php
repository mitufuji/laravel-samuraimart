<?php

use Illuminate\Support\Facades\Route;
// 使うコントローラー指定する
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

// resource　CRUDのルーティングを一度にできる。
// 本来は　Route::HTTPリクエストメソッド名('URL', [コントローラ名::class, 'アクション名'])->name('ルートの名前');
Route::resource('products', ProductController::class)->middleware(['auth', 'verified']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

