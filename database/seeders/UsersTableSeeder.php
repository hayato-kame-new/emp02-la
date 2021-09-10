<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// 追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fnames = ["佐藤", "鈴木", "高橋", "田中"];
        $gnames = ["太郎", "次郎", "花子"];

        // 文字列中の変数の式展開にはダブルクオーテーションを使用すること シングルクオーテーションで囲んだ文字列の中で変数を記述しても変数展開は行われません
        for($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => "{$fnames[$i % 4]}" . " " . "{$gnames[$i % 3]}",
                'email' => 'aaa' . $i . '@example.com',
                'password' => Hash::make('password' . $i),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }

        for($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'テストユーザー' . $i,
                'email' => 'bbb' . $i . '@example.com',
                'password' => Hash::make('testtest' . $i),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }

        for($i = 1; $i <= 30; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10) . '@example.com',
                'password' => Hash::make('randomtest' . $i),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }



    }
}
