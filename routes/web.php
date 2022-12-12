<?php

use Illuminate\Support\Facades\Route;
// 使うコントローラー指定する
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;

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

Route::post('reviews',[ReviewController::class,'store'])->name('reviews.store');
// resource　CRUDのルーティングを一度にできる。
// 本来は　Route::HTTPリクエストメソッド名('URL', [コントローラ名::class, 'アクション名'])->name('ルートの名前');
// middlewareHTTPリクエストが送られたタイミングで実行される処理を定義できる機能
// middleware->('auth')で未ログインならログインページにリダイレクト
// verified　メール認証まだならメール送信画面へ
Route::resource('products', ProductController::class)->middleware(['auth', 'verified']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

