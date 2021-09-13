<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
     /**
     * Run the migrations.
     * こっちが、主テーブルになります。employeesの親テーブルです テーブル作成や、シードファイル作成、マイグレーション実行、シード実行は、親テーブルから先にやる。
     * シードのデータ数も、テテなし子が無いように、親のテーブルのデータ数の方が多いようにする。
     * 主キーは 文字列 オートインクリメントはなし。プライマリーキーだけつける。自動生成するのは、コントローラで自分で処理を書く
     * タイムスタンプを使用しない
     * @return void
     */

    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            // $table->id();
            // id()  メソッドは、　bigIncrements('id') のエイリアス（別名）です。　プライマリーキーになる 自動インクリメントもついてる。

            // 今回は、主キーが文字列  モデルのクラスにも、設定が必要です
            // stringメソッドだけは、第２引数に文字数を設定できますが、integerには、付けないでください。プライマリーキーが設定されてしまいます。０以外はtrueになり、設定されるので。
            // 'department_id' カラムは、 従テーブルのemployeesから、参照されます。データ型を合わせてください。
            // employeesの'department_id'カラムと データ型を合わせる必要がある
            $table->string('department_id', 20)->primary();  // 主キーを文字列にする 部署ID オートインクリメントは無し
            $table->string('department', 20)->unique(); // 部署名
            // 今回のテーブルは、タイムスタンプいらない  モデルにも、いらない設定を書かないといけません。
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
