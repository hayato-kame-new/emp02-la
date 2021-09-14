<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//追加
use App\Models\Department;
// 例外クラスは、App\Http\Controllers\QueryException　では無いので注意する  Illuminate\Database\QueryExceprion  の方を使う
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{

    public function index()
    {
        //$departments = Department::all();
        // all()クラスメソッドの戻り値は Illuminate\Database\Eloquent\Collection オブジェクト
        // dd($departments);
        // dd(count($departments));

        // 'D01'  うまく並び替えるためには 2文字目から最後までを取り出してから、並べ替えをします。
         $departments = DB::select('select department_id, department_name from departments order by substring(department_id , 2)');
        return view('departments.index', ['departments' => $departments]);
    }

    public function new_edit(Request $request)
    {
        // dd($request->dep_id);  //  "D02"  になってる


    }
}
