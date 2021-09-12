<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加  trait である  PasswordValidationRules  を使う
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    //  UpdateUserPssword.php 参考にする
    use PasswordValidationRules;
        /*
        ルーティングでは resourceメソッドを使ってます。
        php artisan route:list　調べると
         GET|HEAD      password/{password}/edit         password.edit
         {} パラメータのキーがpassword になりますので、link_to_route　第3引数に ['password' => Auth::user()->id] と書いて
         パラメータに値をセットしてますので、 コントローラでは、 $request->password で取得できます
         http://localhost:8000/password/51/edit   キーが password  値が "51" とか
         */


    /**
     * Show the form for editing the user's password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        // dd($request->password);  //  "51" とか
        $user = User::find($request->password); // findの引数は、プライマリーキーの値です

        return view('password.edit', ['user' => $user]);
    }

    // ルーティングでは resourceメソッドを使ってるので、依存性注入  メソッドインジェクションで、いきなり$idが引数に書けます。
    // public function edit($id) {
    //     $user = User::find($id);
    //     return view('password.edit', ['user' => $user]);
    // }

    /**
     * Update the users password.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        // dd($request->password);  // 'method' => 'put'　だから、リクエストボディから 新しいパスワードが入ってくる "misamisa1" とか
        // http://localhost:8000/password/51

        // dd($request->get('current_password'));  // 現在のパスワード欄から送られた文字列
           //現在のパスワードが正しいかを調べる
           if(!(Hash::check($request->get('current_password'), Auth::user()->password))){
            return redirect()->back()->with('flash_message', '現在のパスワードが間違っています。');
        }

          //現在のパスワードと新しいパスワードが違っているかを調べる  strcmp  が　0 を返せば 　等しい 同じ
          if(strcmp($request->get('current_password'), $request->get('password')) == 0) {
            return redirect()->back()->with('flash_message', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        //パスワードのバリデーション。新しいパスワードは8文字以上、password_confirmationフィールドの値と一致しているかどうか。
        $validated_data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //パスワードを変更
        $param = [
            'password' => bcrypt($request->get('password')),
        ];
        $user = User::find($id);
        $user->fill($param)->save();

        // ルーティングは resoucesメソッドを使ってるので redirect('users/:id') です。詳細ページにリダイレクトしますが。その前に、ログインし直しになり、その後で詳細ページに行きます。
        // また、新しいパスワードでログインし直しになりますので、ログインページに行きます。ので、フラッシュメーっセージは表示できなくなるので  セッションに保存しても ->with('flash_message', 'パスワードを変更しました。'); なくなる できない
        // return redirect('users/:id')->with('flash_message', 'パスワードを変更しました。');
        // return redirect('users/:id');  // できなかった　何か違う  php artisan route:list で確認してみる
        //  GET|HEAD  | users/{user}                     | users.show
        // 詳細ページへ 行きたい
        return redirect(route('users.show', [
            'user' => $id,
        ]));
       //  return redirect('/users');  // 一覧ページに行くのなら簡単だけど
    }


}
