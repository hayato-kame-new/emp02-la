<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//追加
use App\Models\Department;
use App\Models\DepartmentLogic;
// 例外クラスは、App\Http\Controllers\QueryException　では無いので注意する  Illuminate\Database\QueryExceprion  の方を使う
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{

    public function index()
    {
        //$departments = Department::all();
        // all()クラスメソッドの戻り値は Illuminate\Database\Eloquent\Collection オブジェクト
        // all()クラスメソッド だと、取り出したデータがプライマリーキーが文字列のため、順番が狂います、
        // dd($departments);
        // dd(count($departments));

        // 'D01'  うまく並び替えるためには 2文字目から最後までを取り出してから、並べ替えをします。
         $departments = DB::select('select department_id, department_name from departments order by substring(department_id , 2)');
        return view('departments.index', ['departments' => $departments]);
    }


    public function new_edit(Request $request)
    {
        /*
        クエリー文字列ということは、GETで送られてきてること aリンクと同じ
        http://localhost:8000/departments/new_edit/D02?action=edit
        ルーティングは、パラメータ付きのパスにしてる {} の中にある dep_id が キーになる  D02  が実際に送られてきた値です。
        なので、コントローラの側では、 $request->キー  で　値を取得できます。 dd($request->dep_id); で確認してみる
        Route::get('/departments/new_edit/{dep_id?}', [DepartmentsController::class, 'new_edit'])->name('departments.new_edit');
        パラメータの D02 が   ルーティングのパスの  departments/new_edit/{dep_id?}  の {dep_id?} の値として送られてる
        */

        //  dd($request->action);
        //   dd($request->dep_id);  // 新規だと null  　編集では "D01"  とかになってる

        switch($request->action) {
            case 'add':
                $department = new Department();// 中身は、それぞれのデータの規定値になってる。string型なら、null
                // dd($department->department_id); // null
                break;
            case 'edit':
                /*
                パスについてるパラメータを取得
                Route::get('/departments/new_edit/{dep_id?}', [DepartmentsController::class, 'new_edit'])->name('departments.new_edit');　
                $request->dep_id で　部署IDを取得できる、 それを元に Departmentモデルのオブジェクトを取得する
                */
                $department = Department::find($request->dep_id);  // findクラスメソッドの引数は、プライマリーキーの値にするルール
                // dd($department);
                break;
            }
            // dd($department);
            $param = [
                'department' => $department,
                'action' => $request->action,
            ];

        // ビューで表示させる
        return view('departments.new_edit', $param);
    }

    public function create_update(Request $request){
        /*
         {}のパラメータの名前（キー）に、? が無いので 必須パラメータです
            Route::post('/departments/create_update/{dep_id}',[DepartmentsController::class, 'create_update'])->name('departments.create_update');
        */
        // dd($request->action);

        // 編集だと、フォームでPOSTなので、リクエスト本体から取得する 編集では "D01" とか入ってる
        // 新規 link_to_route だと パスの後ろの {} 任意パラメータから取得する  新規では　null
        // 新規 link_to だと パスの末尾の ? 以降の クエリーパラメータ からaction　を取得

        // dd($request->dep_id);  // 新規だと null
         // dd($request->department_name);

        switch($request->action) {
            case 'add':

                // バリデーションして
                

                // まず、文字列型のプライマリーキーを生成するメソッドをロジッククラスから呼び出す
                // 処理インスタンスを生成
                $logic = new DepartmentLogic();
                $generated_id = $logic->generateDepartmentId();
                //  dd($department_generated_id);// "D04" とか
                $department = new Department(); // PHPは、コンストラクタの多重定義できないから、ひとつひとつ、フィールドにセットしていく
                $department->department_id = $generated_id;
                $department->department_name = $request->department_name;
                $department->save();
            break;

            case 'edit':
            break;
        }

        return redirect('/departments');


    }
}
