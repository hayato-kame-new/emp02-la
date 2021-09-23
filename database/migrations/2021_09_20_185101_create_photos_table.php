<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// 追加
use Illuminate\Support\Facades\DB;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            // $table->id();

            $table->bigIncrements('photo_id');
            // このbigIncrementsメソッドは主キーに相当するカラムを作成しますので、これだけで、主キーとなってます。
            // 自動インクリメントUNSIGNED BIGINT（主キー）に相当するので、自動採番します。この'photo_id'　カラムは、従テーブルから参照されるカラムになります。
            // 従テーブルのemployeesテーブルでは、データ型を合わせるために、unsignedBigIntegerメソッドを使ってください(外部キーのカラム'photo_id'に)
            // Photoモデルクラスに、primaryKeyの変更を書いてください　


            // ここで、Blob型を書かないでください。binaryメソッドでは、バイナリーデータが大きくて、間に合わないので。
            // $table->binary('photo_data')->nullable();  // コメントアウトする

            $table->string('mime_type')->nullable();
            $table->timestamps();
        });
         // ここで　書いてください   MEDIUMBLOB　じゃないと、データが保存できないからです
        // Blob型だと小さすぎるからです、  MEDIUMBLOBの書き方はメソッドは無いから
        DB::statement("ALTER TABLE photos ADD photo_data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
