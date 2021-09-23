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
