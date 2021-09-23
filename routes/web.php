<?php

use Illuminate\Support\Facades\Route;
// 追加
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;
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
Route::resource('/users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
// ユーザパスワードは、別のコントローラで作る   resource 使う
Route::resource('/password', PasswordController::class, ['only' => ['edit', 'update']]);

Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments.index');

//  /departments/new_edit/{dep_id?}  のパラメータは、?をつけて任意パラメータにする。
// 新規の時には、パラメータつけないでアクセスするから {} の値が nullになるため、
//  任意パラメータにしないとエラーになる
Route::get('/departments/new_edit/{dep_id?}', [DepartmentsController::class, 'new_edit'])->name('departments.new_edit');
// {}のパラメータの名前（キー）に、? が無いとエラー  任意パラメータです なぜなら、新規登録の時に、nullが値として入ってくるので、任意パラメータにしないとエラーになる
Route::post('/departments/create_update/{dep_id?}',[DepartmentsController::class, 'create_update'])->name('departments.create_update');
// {dep_id}   必須パラメータ　{} の中にあるのは キー
Route::post('/departments/destroy/{dep_id}', [DepartmentsController::class, 'destroy'])->name('departments.destroy');

Route::get('/employees', [ EmployeesController::class, 'index' ])->name('employees.index');

Route::get('/employees/new_edit', [ EmployeesController::class, 'new_edit' ])->name('employees.new_edit');

Route::post('/employees/emp_control', [ EmployeesController::class, 'emp_control' ])->name('employees.emp_control');
