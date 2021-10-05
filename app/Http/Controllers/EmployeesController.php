<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Photo;
use App\Models\Department;

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

           //　この処理はビューコンポーザに取り出せたら良い　後で　
        $departments = Department::all();  // セレクトボックスのために必要 戻り値は　(        // dd($departments);  // コレクション
            // dd($departments->all());  // これは　配列に変換したもの  0 => App\Models\Department
            $dep_array = $departments->all();

            // 連想配列にしてください！！

            $dep_name_array = [];
            foreach($dep_array as $dep) {
                // dd($dep->department_name);
                // dd($dep->department_id);
                // 連想配列の作り方 $変数[キー] = 値
                $dep_name_array[$dep->department_id] = $dep->department_name;
            }
            // dd($dep_name_array);  // "D01" => "総務部"  "D02" => "営業部"  "D03" => "経理部" などが入った連想配列になってる

            switch ($action) {
                case 'add':  //// 新規登録まず、親データの写真から行う 親データインスタンスと 子データインスタンスを生成する
                    $photo = new Photo(); // 親データのインスタンス
                    $employee = new Employee(); // 子データのインスタンス
                    $params = [
                        'photo' => $photo,
                        'employee' => $employee,
                        'action' => $action,
                        'dep_name_array' => $dep_name_array,
                        'emp_id' => $request->emp_id,  // 　　/employees/new_edit/{emp_id?}　この任意パラメータから取得する
                    ];
                    return view('employees.new_edit', $params);
                    break;

                case 'edit':
                    $photo = Photo::find($request->photo_id);
                    $employee = Employee::find($request->emp_id);
                    $params = [
                        'photo' => $photo,
                        'employee' => $employee,
                        'action' => $action,
                        'dep_name_array' => $dep_name_array,
                        'emp_id' => $request->emp_id,
                    ];
                    return view('employees.new_edit', $params);
                    break;
            }
        }


        public function emp_control(Request $request)
        {
            // dd($request->action);
            $action = $request->action;
            switch ($action) {
                case 'add':
                    $photo = new Photo();
                    $employee = new Employee(); // 従テーブル（子テーブル）
                    if (isset($request->photo_data)) {
                        // dd($request->photo_data);

                        // 一時的に保存しているファイルのパスを取得する
                        $path_name = $request->photo_data->getRealPath();
                        // dd($path_name);  //  "/private/var/folders/mt/vf6k6n6s3hx9nrj2qx2kpc2c0000gq/T/php3iGR4c"  などと取得できます
                        // file_get_contents — ファイルの内容を全て文字列に読み込む 失敗した場合、file_get_contents() は false を返します。
                        $file_data = file_get_contents($path_name);
                        $photo_data = null;
                        if ($file_data !== false) {
                            $photo_data = base64_encode($file_data);
                            // dd($photo_data);
                        }
                        // $info = pathinfo($request->photo_data);
                        // dd($info);
                        // 画像タイプの確認
                        $mime_type = $request->photo_data->getMimeType();
                        // dd($request->photo_data->getMimeType());  // "image/jpeg" などと取得できる

                         // 今回は、フォームリクエストを使ってバリデーションするのでコメントにする
                    // $this->validate($request, Photo::$rules, Photo::$messages );
                    // dd($request->photo_data);

                        $param = [
                            'photo_data' => $photo_data,
                            'mime_type' => $mime_type,
                        ];
                        $photo->fill($param)->save();

                    } else {
                        // アップロードしてこない場合 null許可してるカラムなので、アップロードして来なくても、良い。
                        // その場合には、親テーブルphotosにデータが無いと、外部キーの photo_id で親テーブルデータがないと怒られるので、子テーブルのemployeesテーブルが登録できないので、
                        // photosテーブルに、 photo_data mime_type　カラムに　null　を入れて、データを登録しておく
                        $photo->photo_data = null;
                        $photo->mime_type = null;
                        // dd($photo->save());  // 成功すると true
                        $photo->save();
                    }
                    // 続いて子テーブルemployees

                     // バリデーションは、フォームリクエストで行うのでここではコメントにする
                // $this->validate($request, Employee::$rules, Employee::$messages);

                     // 社員IDを作る
                $last = DB::table('employees')->orderBy('employee_id', 'desc')->first();
                $resultStrId = "EMP0001";  // 初期値
                if (isset($last)) {
                    $strId = $last->employee_id;  //文字列を取得
                     // 数字の部分を取得して数値に変換して １を足す
                    $num = intval(substr($strId, -4)) + 1 ;
                    // 文字列のフォーマット 部署IDができた
                    $resultStrId = sprintf("EMP%04d", $num);
                }
                // もし $last が null だったら、初期値をセットする
                // ここで、インスタンスのプロパティに作成した従業員IDをセット
                $employee->employee_id = $resultStrId;

                $employee->name = $request->name;
                $employee->age = $request->age;
                $employee->gender = $request->gender;
                // ここがポイント
                $employee->photo_id = $photo->photo_id;

                $employee->zip_number = $request->zip_number;
                $employee->pref = $request->pref;
                $employee->address1 = $request->address1;
                $employee->address2 = $request->address2;
                $employee->address3 = $request->address3;
                $employee->department_id = $request->department_id;
                $employee->hire_date = $request->hire_date;
                $employee->retire_date = $request->retire_date;
                $employee->save();

                $f_message = "登録に成功しました";

                    break;
                case 'edit':

                    // 先に親データのデータベースから変更する。
                    $photo = Photo::find($request->photo_id); // findメソッドの引数はプライマリーキーの値
                    $employee = Employee::find($request->employee_id);
                    //先に親テーブルphotosに保存
                    // dd($request->all());
                    // dd($photo);
                    // dd($request->photo_data); // ファイルアップロードがあるかどうか 無いと null
                    // dd(isset($request->photo_data));  // null判定で isset関数を使う、isset関数はNULL以外であれば戻り値にTRUEを返します。  falseを返せば、 null
                    if(isset($request->photo_data) !== false) {  // ファイルアップロードファイルが 選択されてる
                        // dd($request->photo_data->getRealPath()); //   "/private/var/folders/mt/vf6k6n6s3hx9nrj2qx2kpc2c0000gq/T/phpDTUJUv"

                        $path_name = $request->photo_data->getRealPath();
                        $file_data = file_get_contents($path_name);
                        // dd($file_data); // バイナリーデータ
                        // dd (isset($file_data));  // あれば true
                        $photo_data = null;
                        if (isset($file_data)) {
                            // Base64でエンコードする  Base64は、マルチバイト文字列や、画像などのバイナリ・データをテキスト形式に変換する手法の1つ
                            $photo_data = base64_encode($file_data);
                            // dd($photo_data);
                            // dd($request->photo_data->getMimeType());  // "image/jpeg" 　など
                            $mime_type = $request->photo_data->getMimeType();
                            $param = [ 'photo_data' => $photo_data, 'mime_type' => $mime_type];
                            // dd($photo->update($param));  // 成功すれば true

                            $photo->update($param);  //  $photo->fill($param)->save();
                        }
                    }
                        // 続けて、従テーブルのemployeesテーブル操作する
                    // バリデーション
                    // $this->validate($request, Employee::$rules, Employee::$messages);

                    // 社員ID 以外を上書き保存する
                    $employee->name = $request->name;
                    $employee->age = $request->age;
                    $employee->gender = $request->gender;
                    // ここがポイント 写真を差し替えているかもしれないので、差し替えてなくてもする
                    $employee->photo_id = $photo->photo_id;

                    $employee->zip_number = $request->zip_number;
                    $employee->pref = $request->pref;
                    $employee->address1 = $request->address1;
                    $employee->address2 = $request->address2;
                    $employee->address3 = $request->address3;
                    $employee->department_id = $request->department_id;
                    $employee->hire_date = $request->hire_date;
                    $employee->retire_date = $request->retire_date;
                    $employee->save();
                    // ここまで来るってことは、エラーがなかったということ

                    $f_message = "登録に成功しました";
                    break;
                case 'cancel':
                    // dd($action);
                    break;
                }
                return redirect('/employees')->with('flash_message', $f_message);

        }


        public function delete(Request $request)
        {
            // dd($request->photo_id);
            // dd($request->employee_id);
            // リレーションの ->onDelete('cascade')  をつけた　これは、
            // 親テーブルのデータ一行分を削除すると、関連する子テーブルがあっても、
            // エラーにならないで、関連する子テーブルのデータも一緒に消去できるようになるというもの
            // ですから、親テーブルを削除するだけで、関連する子テーブルのデータも一行分削除できている
            $employee = Employee::find($request->emp_id);
            // dd($employee->photo->photo_id);
            $photo = Photo::find($employee->photo->photo_id);
            // dd($photo->photo_id);
            //  dd($photo->delete());

            // 削除の処理は親テーブルだけで良し
            $photo->delete();

            $f_message = "削除しました";
            return redirect('/employees')->with('flash_message', $f_message);
        }


        public function find(Request $request)
        {
            $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
            // dd($departments->all());
            $depArray = $departments->all();
            // dd($depArray[0]->department_name);
            $dep_name = []; //配列の初期化   キーが　D01   値が 総務部  などの連想配列にしたい
            foreach($depArray as $dep){
                // [] にキーを指定して、連想配列を作成できます！！
                $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
            }
            // 注意、配列変数をデバックするときには[]を入れてはいけません
            // dd($dep_name);

            // $unselected = ['D00' => '未選択'];
            // マージする
            // $mergeDep = array_merge($unselected , $dep_name);
            // dd($mergeDep);
            $employees = []; // 空の配列
            $result = '';
            return view( 'employees.find', [ 'result' => $result, 'dep_name' => $dep_name , 'employees' => $employees]);
        }
        public function search(Request $request)
        {

            $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
            // dd($departments->all());
            $depArray = $departments->all();
            // dd($depArray[0]->department_name);
            $dep_name = []; //配列の初期化   キーが　D01   値が 総務部  などの連想配列にしたい
            foreach($depArray as $dep){
                // [] にキーを指定して、連想配列を作成できます！！
                $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
            }
            // 注意、配列変数をデバックするときには[]を入れてはいけません
            // dd($dep_name);

            // $unselected = ['D00' => '未選択'];
            // マージする
            // $mergeDep = array_merge($unselected , $dep_name);


            $dep_id = $request->department_id;
            $emp_id = $request->emp_id;
            $word = $request->word;
            // 未選択ならnull
            // dd($dep_id);
            // dd($emp_id);
            // dd($word);
            // $employees = Employee::where('department_id', $dep_id)->get();
            $result = '';
            // if($dep_id == null && $emp_id == null　&& $word == null){
                if (empty($dep_id) && empty($emp_id) && empty($word)){
                $result = '何か入力してください';
                $employees = [];
               return view('employees.find', ['result' => $result, 'dep_name' => $dep_name ,'employees' => $employees]);
               // return が実行されていたら、以降に書いてあるのは実行されない
            }else {
                $employees = Employee::search($dep_id, $emp_id, $word)->get();
                if (count($employees) > 0){
                    $result = '検索結果です';

                } else {
                    $result = '0件でした';
                }
            }

            // dd($employees);
            // $employees = Employee::depIdSearch($dep_id)->empIdSearch($emp_id)->nameSearch($word)->get();
            // セッションに $request->session()->put('employees', $employees) と同じ意味です
        //    return redirect('/employees')->with(['employees'=> $employees]);
        return view('employees.find', ['result' => $result, 'dep_name' => $dep_name ,'employees' => $employees]);
        }


        public function postCSV(Request $request)
        {
            // 出力データ
            $employees = Employee::all();
            // dd($employees);
            // 出力のための
            $head = [ "社員ID","名前","年齢","性別","写真ID","郵便番号","都道府県","住所1","住所2","住所3","部署ID","入社日","退社日", "作成日", "更新日" ];

            // 書き込み用ファイルを開く
            $file = fopen('test.csv', 'w');
            // dd($file);
            if($file){
                // 見出しの書き込み
                mb_convert_variables('SJIS', 'UTF-8', $head);
                fputcsv($file, $head);
                //  データの書き込み
                foreach ($employees->toArray() as $employee){
                    // dd($employee);
                    mb_convert_variables('SJIS', 'UTF-8', $employee);
                    fputcsv($file, $employee);
                }
            }
            fclose($file);  // ファイルを閉じる

            // HTTPヘッダ
            header("Content-Type: application/octet-stream");
            header('Content-Length: '.filesize('test.csv'));
            header('Content-Disposition: attachment; filename=test.csv');
            readfile('test.csv');
            // publicの下にtest.csvというCSVファイルが作成されている
            return redirect('/employees')->with('flash_message' ,'CSVファイルに保存しました。');
        }

}
