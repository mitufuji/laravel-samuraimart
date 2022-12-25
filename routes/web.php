<?php

use Illuminate\Support\Facades\Route;
// 使うコントローラー指定する
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserCountroller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
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

Route::get('/',[WebController::class,'index']);

Route::controller(CartController::class)->group(function () {
    Route::get('users/carts', 'index')->name('carts.index');
    Route::post('users/carts', 'store')->name('carts.store');
    Route::delete('users/carts', 'destroy')->name('carts.destroy');
});
// Route::contoroller(共通のコントローラー)->group(function(){})
Route::controller(UserCountroller::class)->group(function() {
    Route::get('users/mypage','mypage')->name('mypage');
    Route::get('users/mypage/edit','edit')->name('mypage.edit');
    Route::put('users/mypage','update')->name('mypage.update');
    Route::get('users/mypage/password/edit','edit_password')->name('mypage.edit_password');
    Route::put('users/mypage/password','update_password')->name('mypage.update_password');
    Route::get('users/mypage/favorite','favorite')->name('mypage.favorite');
    Route::delete('users/mypage/destroy','destroy')->name('mypage.destroy');
    Route::get('users/mypage/cart_history','cart_history_index')->name('mypage.cart_history');
    Route::get('users/mypage/cart_history/{num}', 'cart_history_show')->name('mypage.cart_history_show');
    Route::get('users/mypage/register_card', 'register_card')->name('mypage.register_card');
    Route::post('users/mypage/token', 'token')->name('mypage.token');


});
Route::post('reviews',[ReviewContrshow::class,'store'])->name('reviews.store');

Route::get('products/{product}/favorite',[ProductController::class,'favorite'])->name('products.favorite');
// resource　CRUDのルーティングを一度にできる。
// 本来は　Route::HTTPリクエストメソッド名('URL', [コントローラ名::class, 'アクション名'])->name('ルートの名前');
// middlewareHTTPリクエストが送られたタイミングで実行される処理を定義できる機能
// middleware->('auth')で未ログインならログインページにリダイレクト
// verified　メール認証まだならメール送信画面へ
Route::resource('products', ProductController::class)->middleware(['auth', 'verified']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

