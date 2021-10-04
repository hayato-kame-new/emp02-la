<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Photo;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', [ 'employees' => $employees ]);
    }

     // まず、親の写真の表示、編集、アップロードから考える。
     public function new_edit(Request $request)
     {

        // {}のパラメータの名前（キー）に、? が無いとエラー  任意パラメータです なぜなら、新規登録の時に、nullが値として入ってくるので、任意パラメータにしないとエラーになる
//  Route::get('/employees/new_edit/{emp_id?}', [ EmployeesController::class, 'new_edit' ])->name('employees.new_edit');
// //  {!! link_to_route('employees.new_edit', '編集', [ 'action' => 'edit', 'emp_id' => $employee->employee_id ], ['style' => 'color:white;']) !!}

         /*
        クエリー文字列ということは、GETで送られてきてること aリンクと同じ   $request->emp_id でコントローラで取得できる
        http://localhost:8000/employees/new_edit/EMP0001?action=edit
        ルーティングは、パラメータ付きのパスにしてる {} の中にある emp_id が キーになる  EMP0001  が実際に送られてきた値です。
        なので、コントローラの側では、 $request->キー  で　値を取得できます。 dd($request->emp_id); で確認してみる
        Route::get('/employees/new_edit/{emp_id?}', [ EmployeesController::class, 'new_edit' ])->name('employees.new_edit');
        パラメータの EMP0001 が   ルーティングのパスの  /employees/new_edit/{emp_id?}  の {emp_id?} の値として送られてる
        ? をつけて 任意パラメータにしてください！！　なぜなら、新規の時には nullで送られてきますので、 nullでもエラーにならずに済むように、してください！！
        */

        //  dd($request->action);
        //  http://localhost:8000/employees/new_edit/EMP0001?action=edit
        //  {!! link_to_route('employees.new_edit', '編集', [ 'action' => 'edit', 'emp_id' => $employee->employee_id ], ['style' => 'color:white;']) !!}
//Route::get('/employees/new_edit/{emp_id?}', [ EmployeesController::class, 'new_edit' ])->name('employees.new_edit');
        // dd($request->emp_id);  // 新規だと null  　編集では "EMP0001"  とかになってる

         $action = $request->action;

        // 新規登録まず、親データの写真から行う 親データインスタンスと 子データインスタンスを生成する
        $photo = new Photo();
        $employee = new Employee();
        $params = [
            'photo' => $photo,
            'employee' => $employee,
            'action' => $action,
            'emp_id' => $request->emp_id,
        ];
        return view('employees.new_edit', $params);
        }

    public function emp_control(Request $request)
    {

    }

}
