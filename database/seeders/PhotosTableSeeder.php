<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//追加
use App\Models\Photo;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * photosテーブルは、親テーブル　　employeesテーブルが子テーブル  １対１でリレーションだから、
     * 写真のデータ数は、たとえ、photo_data　が nullable でも、データ自体は、インスタンスとして、存在する必要があるため、
     * 子テーブルのデータ数だけ、必要です。なので、12データ作成します。先にPhotoモデル作ること。
     * fillメソッド使えるように、モデルに、　protected $fillable = ['photo_data', 'mime_type']; を書き、
     * 'photo_data', 'mime_type'　をfillメソッドで一気に保存できるようにし、
     * protected $guarded = ['photo_id', 'mime_type' , 'photo_data'];  として fillメソッドを使った時? saveメソッドの時? に
     * 値をセットしなくても、データ保存時にエラーにならないようにする。
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 12; $i++) {
            $param = [
                'photo_data' => null,
                'mime_type' => null,
            ];
            $photo = new Photo();  // このやり方の場合、モデル作成が先です。
            $photo->fill($param)->save(); // モデルでfillメソッドのための、処理を書いておいてください。save()メソッドのための処理も書く

            // もしくはこのやり方でもOK これだと、モデルがまだ作ってなくても、データベースへデータを入れられる。
            // DB::table('photos')->insert($param);
        }
    }
}
