<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploeesTable extends Migration
{
    /**
     * Run the migrations. カラムは、そのまま、モデルのフィールドになる。
     * 主キーはstringメソッドを使う ->primary() も呼び出す。 自動採番はしない。
     * employeesテーブルは、従テーブルです。(departmentsテーブルが親  また、photosテーブルも親としてリレーションがある)
     *
     * $table->integer('age')の第二引数には、stringメソッドのような整数を、代入しないでください。第二引数は、指定しなければ 0がデフォルト値になってるけど、
     * 0以外を指定すると、プライマリーキーを指定したことになりますので、注意。integerメソッドの 第二引数のデフォルト値は、falseなので、trueになると、そのカラムが、プライマリーキーになってしまいます！！
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            // $table->id();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            // 主キー 文字列で、'employee_id' カラム  モデルのfindメソッドの引数が、プライマリーキーの付いた カラムの値になります。
            $table->string('employee_id', 30)->primary();
            $table->string('name', 50);
            // integerメソッドの引数注意。第二引数には、指定入れないでください。プライマリーキー指定です。
            $table->integer('age');
            // 性別は、整数で管理する 1:男  2:女
            $table->integer('gender');
            // 外部キーのカラムです。カラムは、そのまま、モデルのフィールドになる。
            // 外部キーでは、主テーブルphotos側の 'photo_id'カラムと、データ型を合わせる必要がある、
            // unsignedBigIntegerメソッドは、UNSIGNED BIGINT同等の列を作成します。
            // photos（主テーブル）の  bigIncrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。
            $table->unsignedBigInteger('photo_id');  // 外部キーのカラム
            // 住所情報関連のカラム
            $table->string('zip_number', 20);
            $table->string('pref', 20);
            $table->string('address1', 100);
            $table->string('address2', 100);
            $table->string('address3', 100);
            // これは、departmentsテーブルに対しての、外部キーのカラム
            // 主テーブルがdepartmentsテーブルです 型を合わせる必要がある 文字列型になる
            $table->string('department_id');
            // Employeeモデルに、$datesプロパティをオーバーライドすること　日付の成形についての
            $table->datetime('hire_date');  // 入社日
            $table->datetime('retire_date')->nullable(); // 退社日  nullable() 入れないと、null代入できないので 入れる
            $table->timestamps();

            // 外部キー制約 従テーブル側に書く
            $table->foreign('department_id')->references('department_id')->on('departments');
            // ->onDelete('restrict') がついているのと同じになってる。親テーブルのデータに対して、削除をしようとしたら、紐づいた子テーブルのデータがあれば、消すべきでは無い、->onDelete('restrict')　エラーが発生します。
            // コントローラでは、エラー処理のため、try catch で囲っている 部署データを削除しようとしたとき、その部署に属している従業員がいた時には、エラー発生する。１対多のリレーションを 各モデルに設定してる

            // 外部キー制約 従テーブル側に書く
            $table->foreign('photo_id')->references('photo_id')->on('photos')->onDelete('cascade');
            // ->onDelete('cascade') をつける  // ->onDelete('cascade')で 親のデータを更新を行うときそのデータに紐づく子のデータも更新される
            // 親テーブルで写真を変更などしたときに、photosテーブルの photo_idカラムを変更更新した時、子テーブルの外部キー（photo_idカラム）の値も、変更される、更新の時！！
            // 写真を削除する、って動作は、作成していませんので、写真を削除され、連動で、従業員も削除される心配はない。
            // 1対１のリレーションを 各モデルで設定してる 親のphotosテーブルのデータを更新すると、子テーブルの外部キーの値も書き換えられる。

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }

}
