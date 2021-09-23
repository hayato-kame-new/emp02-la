<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    //primaryKeyの変更
    protected $primaryKey = 'photo_id';

    // fillメソッドを使う時に、このカラムを一気にセットして、保存できる
    protected $fillable = ['photo_data', 'mime_type'];

    protected $guarded = ['photo_id', 'mime_type', 'photo_data']; // 'photo_id'カラムは 自動採番 後から変更もしない

// Photoモデルは、主データです。 Employeeが　従データです。先に Employeeモデルを作成する
    // １対１のリレーションです  hasOne設定   employee() というふうにメソッド名は単数型にする
    public function employee() {
        return $this->hasOne(Employee::class, 'employee_id'); // 第二引数外部キー
    }


}
