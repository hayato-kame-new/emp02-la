<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加
use App\Models\User;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function edit(Request $request) {
        // dd($request->user);  // "51" とか入ってる
        //  http://localhost:8000/users/51/edit
        //  URI は users/{user}/edit なので、 $request->user で、クエリーパラメータで取り出せる  {user}  が、キーの名前 値が "51"
        $user = User::find($request->user);
        return view('users.edit', ['user' => $user]);
    }

    // resourceメソッドでルーティングしてるので、こっちでもいい
    /*
    public function edit($id) {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }
    */


    public function update(Request $request) {
        /*
        http://localhost:8000/users/51
        users/{user}  の　{} のパラメータのところに、　Auth::user()->id　の返り値が入る
        Auth::user()->id  は、 Auth::id() と同じ
        パラメータは キーが {}の中に書いてある名前なので、$request->user で、値を取得できる　
        */

        // dd($request->user);  // "51" とか入ってる

        $user = User::find($request->user);   // モデルクラスの クラスメソッドの find の引数は、プライマリーキーの値をセットするルールです

        /*
        バリデーションエラーが発生した場合、自動的に元のページへリダイレクトされ、さらに $errors 変数にエラーメッセージが格納されます。
        そのため、 View側で $errors があるか確認し、あれば表示するという処理を追加すればOKです。また、 $errors と複数形で書いてある通り、複数のエラーが保存されることもあります。
        */
        // バリデーション 'name' と 'email' に関して  CreateNewUser.php  を参考にして
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            /*
            これだと、必ずメルアドを変更しないといけなくなるので、
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             重要！！　メールアドレスは、ユニークだけど、自分のメルアドを変更する時には、自分のメルアド変更しなくても構わないようにします。
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            または
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('App\Models\User')->ignore($user->id)],
            にする
             select count(*) as aggregate from `users` where `email` = misamisa@misa.com and `id` <> 51  という、SQL文が生成されています。
             */

            // これでもいいですけど
             'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
             // こっちでもいいです
         //   'email' => ['required', 'string', 'email', 'max:255', Rule::unique('App\Models\User')->ignore($user->id)],
        ]);
        // 取得できた オブジェクトで、更新します。
        $param = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $user->fill($param)->save();
        /*
        User.php モデルの　$fillable フィールドに、以下のように設定してますので、fillメソッドで、一気にセットできます
        protected $fillable = [
            'name',
             'email',
             'password',
         ];
         */
        return redirect('/users');
    }


    // resourceメソッドでルーティングしてるので、こっちでもいい
    /*
    public function update($id, Request $request) {
        $user = User::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('App\Models\User')->ignore($user->id)],
        ]);
        $param = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $user->fill($param)->save();
        return redirect('/users');
    }
    */


}
