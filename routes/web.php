<?php

use Illuminate\Support\Facades\Route;
// 追加
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PasswordController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// resource 使うと、名前をつけたように使える 'users.index' とか 'users.show'とか　link_to_route　で使えるらしい
// php artisan route:list　のコマンドで、確認してみて
Route::resource('/users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update']]);
// ユーザパスワードは、別のコントローラで作る   resource 使う
Route::resource('/password', PasswordController::class, ['only' => ['edit', 'update']]);

