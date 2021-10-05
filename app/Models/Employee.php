<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 追加
use App\Models\Department;


class Employee extends Model
{
    use HasFactory;

    // primaryKeyの変更
    //     Eloquentでは主キーがオートインクリメントで増加する整数値であるとデフォルトで設定されています。
// そのため、オートインクリメントまたは整数値ではない値を主キーを使う場合は$incrementingプロパティをfalseに設定します。
    protected $primaryKey = 'employee_id';

    /**
     * IDが自動増分されるか
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = ['employee_id', 'name', 'age', 'gender', 'photo_id', 'zip_number' ,'pref', 'address',
        'department_id', 'hire_date', 'retire_date'];

    /**
     * 日付を変形する属性
     * デフォルトでEloquentはcreated_atとupdated_atカラムをCarbonインスタンスへ変換します。
     * CarbonはPHPネイティブのDateTimeクラスを拡張しており、便利なメソッドを色々と提供しています。
     * モデルの$datesプロパティをオーバーライドすることで、
     * どのフィールドを自動的に変形するのか、逆にこのミューテタを適用しないのかをカスタマイズできます。
     * @var array
     */
    protected $dates = ['hire_date', 'retire_date' ];

    protected $guarded = ['employee_id', 'photo_id' ,'retire_date'];


    // 主データが　Departmentモデルです。
    // Employeeモデルは、従データなので belongsToを設定する 一人の従業員は一つの部署に所属する 部署はたくさんの従業員を持つ 1対多のリレーション
    // department()　単数形のメソッド名にする 一つの部署に所属するから
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id'); // 第二引数外部キー
    }

    // 主データが　Photoモデルです。
    // Employeeモデルは、従データなので belongsToを設定する。一人の従業員は、一つの写真データをもつ、1対１のリレーション
    //  photo() 単数形のメソッド名にする 一つの写真データを持つから
    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    // 検索用スコープ
    public function scopeSearch($query, $dep_id, $emp_id, $word)
    {
        if(!empty($dep_id)){
            $query->where('department_id', $dep_id);
        }
        if(!empty($emp_id)){
            $query->where('employee_id', $emp_id);
        }
        if(!empty($word)){
            // これでもいい 文字列展開はダブルクオーテーションでないとダメです
            // $query->where('name', 'like', "%{$word}%");
            $query->where('name', 'like', '%' . $word . '%');
        }
        return $query;
    }

    /**
     * フルの住所を表示するインスタンスメソッド インスタンスメソッドだからthisが使える
     *
     * @return string
     */
    public function getFullAddress(): string {
        return '〒' . $this->zip_number . $this->pref . $this->address1 . $this->address2 . $this->address3;
    }

    /**
     * 性別を int から strign型にする
     * 性別は employeesテーブルでのgenderカラムに対応しているので genderフィールドを持っている
     * genderカラムは 整数の型になってる
     * @param int $gender
     * @return string 1:男<br>2:女
     */
    public function getStringGender($gender)
    {
        $str = "";
        switch($gender) {
            case 1:
                $str = "男";
                break;
            case 2:
                $str = "女";
                break;
        }
        return $str;
    }

}

  // バリデーションのルール ユーザーが入力してくるフィールドを書く
     // requireフィールドでない場合は、データベーステーブルで列をnull許容にします　こっちにも 'nullable'
    // 今回は、サービスプロバイダーを使って、バリデーションしてます
// EmployeeFormRequest    ValidatorServiceProvider  を使ってますので、
// モデルクラスには定義してません

    //  public static $rules = [
    //     'name' => ['required', 'string', 'max:255' ],
    //     'age' => [ 'required' , 'numeric', 'between:0,150' ],
    //     // テンプレートのほう（Formファザード）には、required属性はつけないでおく
    //     'gender' => [ 'required' ,'string', 'size:1', 'in:男,女' ],

    //     // これらを使うと、編集の際に、おかしくなりますので、使いません。
    //     // サービスプロバイダーを使います

    //     // ハイフンありなしどちらでも
    //     // 'zip_number' => [ 'required', 'regex:/^[0-9]{3}-?[0-9]{4}$/'],
    //     // ハイフンアリだけ
    //     // 'zip_number' => [ 'required', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
    //     // 'zip_number' => [ 'required', 'regex:/^\d{3}\-\d{4}$/'],
    //     'zip_number' => [ 'required'],
    //     'pref' => [ 'required' ,'string'],
    //     'address1' => [ 'required' ,'string' ],
    //     'address2' => [ 'required' ,'string'],
    //     'address3' => [ 'required' ,'string'],
    //     'department_id' => [ 'required','string' ],
    //     'hire_date' => [ 'required', 'date' ],
    //     'retire_date' => [ 'nullable', 'date' ],

    // ];

    // エラーメッセージ 今回は、モデルクラスには定義しない

    // public static $messages = [
    //     'name.required' => '名前は必ず入力してください',

    //     'name.max' => '名前は255字以内で記入してください',
    //     'age.required' => '年齢は必ず入力してください',
    //     'age.numeric' => '年齢は数値を入力してください',
    //     'age.between' => '年齢は0以上150以内で入力してください',
    //     'gender.required' => '性別を選択してください',
    //     'gender.in' => '性別を選択してください',
    //     'zip_number.required' => '郵便番号は必ず入力してください',
    //     'zip_number.regex' => '郵便番号は　000-0000 の形式で入力してください',
    //     'pref.required' => '都道府県は必ず入力してください',
    //     'address1.required' => '住所(市区町村郡)は必ず入力してください',
    //     'address2.required' => '住所(町名番地)は必ず入力してください',
    //     'address3.required' => '住所(建物名)は必ず入力してください',
    //     'department_id.required' => '所属を選択してください',
    //     'hire_date.required' => '入社日は必ず入力してください',
    //     'hire_date.date' => '入社日は、日付の形式で入力してください',
    //     'retire_date.date' => '退社日は、日付の形式で入力してください',
    // ];

