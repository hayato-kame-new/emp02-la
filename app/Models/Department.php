<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * モデルのタイムスタンプを更新するかの指示 スーパークラスから持ってる
     * (継承してる)$timestampsフィールドを上書きする boolean型のフィールドに falseの値を代入する
     * タイムスタンプいらない
     * @var bool
     */
    public $timestamps = false;

     /**
     * モデルのプライマリーキーをデフォルトのものから変更するので
     * 主キーは、'department_id'カラムにする
     * @var string
     */
    protected $primaryKey = 'department_id';


    /**
     * IDが自動増分されるか
     * Eloquentでは主キーがオートインクリメントで増加する整数値であるとデフォルトで設定されています。
     * そのため、オートインクリメントまたは整数値ではない値を主キーを使う場合は$incrementingフィールドをfalseに設定します。
     * @var bool
     */
    public $incrementing = false;

    /**
     * ここで設定したカラムが、fillメソッドで一気に保存できるようになります
     * $fillableフィールドの値を代入する
     */
    protected $fillable = ['department_id', 'department_name'];

    /**
     * 新規や、更新などでのデータベース保存時に、このカラムの値がなくても、エラーにならないようにする設定です。
     * $guardedフィールドの値を代入する
     */
    protected $guarded = ['department_id'];

     //利用上は部署テーブルが社員テーブルの親。
    // つまり、部署の下に社員が存在しているという関係
    // 部署にはたくさんの社員がいる(部署 hasMany 社員の関係)
    // 社員はどこか１つの部署に所属している(社員 belongsTo 部署）

    /**
     * hasMany設定
     * こちらのテーブル departmentsテーブルが主テーブルで、employeesテーブルが従テーブル
     * メソッド名は、employees() hasManyだから、複数形になる 自分自身のインスタンスがもつ、インスタンスメソッドのhasMany()メソッドを呼び出す
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'employee_id');// 第二引数外部キー
    }

    /**
     * バリデーションの ルールの フィールドです。staticな、静的なクラスフィールドとして、継承されてるので、自クラスで値を代入する。
     * public で static な クラスフィールドで定義すると、
     * Laravelでは　使う時に、クラス名::メソッド名()で クラスメソッドとして呼び出しできるようになってる Laravelがしてくれてる
     *
     */
    public static $rules = [
        'department_name' => 'required',
    ];

    /**
     * バリデーション時の失敗した時のエラーメッセージ
     * public で static な　クラスフィールドとして継承されてるので、自クラスで値を設定する
     * Laravelでは、使う側は、クラス名.メソッド名() で、クラスメソッドとして、呼び出しができるように、Laravelがしてくれてる
     */
    public static $messages = [
        'department_name.required' => '部署名は必ず入れてください。'
    ];



}
