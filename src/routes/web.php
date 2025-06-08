<?php

use Illuminate\Support\Facades\Route;
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

Route::prefix('products')->group(function(){
    Route::get('/', [ProductController::class, 'index'])->name('products.index');   // 一覧・検索・並び替え
    Route::get('/search',[ProductController::class, 'search'])->name('products.search'); //検索結果
    Route::get('/sort', [ProductController::class, 'sort'])->name('products.sort');  //並び替え結果
    Route::get('/register', [ProductController::class, 'register'])->name('products.register'); // 登録フォーム表示
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');       // 登録処理
    Route::get('/{productId}', [ProductController::class, 'detail'])->name('products.detail'); // 編集フォーム
    Route::put('/{productId}/update', [ProductController::class, 'update'])->name('products.update');  // 更新処理
    Route::delete('/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy'); // 削除処理
});