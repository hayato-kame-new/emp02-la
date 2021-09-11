<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加  trait である  PasswordValidationRules  を使う
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;

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
    

}
