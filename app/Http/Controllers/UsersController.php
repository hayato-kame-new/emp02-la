<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function show(Request $request) {
        /*
         showアクションのルーティングは、 resourceメソッドを使ってるので
         php artisan route:list  コマンドで確認をすると、
         URI は  users/{user}    NAME は　users.show  となっていることがわかる
         users.blade.php の link_to_route で、　クエリーパラメーターをセットしてる
          http://localhost:8000/users/4      users/{user} の　{user} が 4 になってる
         $request->user　で クエリーパラメータの値が取れます。
         dd($request);   requestUri   が  "/users/4" などになってる
         dd($request->user);   "４"が入ってる  つまり、 キーが user 値が クエリー文字列で渡ってきた "4"
        */
        // 引数のrequestオブジェクトから、クエリー文字列の値を取得する
        $id = $request->user; // キー が　user　になることは、 URI を見ればわかる
        // ユーザーオブジェクト取得
        $user = User::find($id);  // findの実引数には、プライマリーキーの値を渡すルールです。
        return view('users.show', ['user' => $user]);
    }

    // Laravelでは、ルーティングに resourceメソッド使った時、引数にダイレクトに $id が書ける仕組みなので、こっちでもいい
    /*
    public function show($id) {
        $user = User::find($id);
        return view('users.show', ['user' => $user]);
    }
    */
}
