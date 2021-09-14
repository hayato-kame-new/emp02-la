<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentLogic {
/*
    PHPのアクセス修飾子
public
どこからでもアクセス可能です。アクセス修飾子がない場合は、publicを指定したものと同じになります。

protected
そのクラス自身と継承クラスからアクセス可能です。つまり非公開ですが、継承は可能となります。

private
同じクラスの中でのみアクセス可能です。非公開で継承クラスからもアクセス不可能となります。
*/

// PHP のメソッド名camelCase記法で記述する　命名規則。 戻り値 nullは許容してないので  ?string ではなくて string
public function generateDepartmentId(): string {
    // dd(Department::orderby('department_id', 'desc')->first());
    /*
    Department::orderby('department_id', 'desc')->first()  これでも大丈夫な時もあるけど、
    データ型が文字列のため、順番が狂ってる時もあるから、SQL文を書くやり方の方がいい
    DB::select('select department_id from departments order by substring(department_id , 2) desc limit 1')
DB::selectが取得するのは、オブジェクトです。 連想配列で取得します。
    mb_substr( string $string,int $start, ?int $length = null, ?string $encoding = null ): string
    文字数に基づきマルチバイト対応の substr() 処理を行います。位置は、 string の始めから数えられます。 最初の文字の位置は 0、2 番目の文字の位置は 1、といったようになります
    */
    $id_array = DB::select('select department_id from departments order by substring(department_id , 2) desc limit 1');
    //  dd($id_array); // 取得したのは 多次元配列でした  まだひとつも登録してない時は、[]  空の配列が返る
    // dd(count($id_array));  // [] 空の配列の時は 0

    if(count($id_array) > 0){
        foreach($id_array as $key => $value) {  // limit 1 だから、　１つしかないけど
            // dd($value);
            foreach($value as $key2 => $value2) {
            //   dd($value2);  // "D03"
            }
        }
    }

     // 確認
     $result = "";
     if(!isset($value2)) {
        $result = "D01"; // 一番最初
    } else {
        $str = substr($value2, 1, 2);  // 切り出し 半角英数字なので、日本語じゃ無いから mb_substr ではない
        //  dd($str); // "03" とかになってる
        // dd(intval($str) + 1);  // 数値の  4
        $result = sprintf("D%02d", intval($str) + 1);
        // dd($result);  // "D04" とかになってる
}
// dd($result);
return $result;

}

}
