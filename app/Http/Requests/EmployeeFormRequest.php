<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     *  もし、アクセスの時のドメインより下のパスが'/employees/emp_get'だったら
     * このFormRequestを利用する。それ以外は、許可しない。
     * $this->path()　は、 $request->path() のことです。
     * http://localhost:8000/employees/emp_get?action=add
     * http://localhost:8000/employees/emp_get?action=edit
     * などのURLの　ドメインより下のものを取得するメソッドです
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == 'employees/emp_get') {
            return true;  // このEmployeeFormRequestの使用を許可する
        } else {
            return false;  // 許可しない
        }

    }

    // post_max_size　　　POSTリクエストの上限サイズ
//  post_max_size   POSTリクエストの中身が8MBを超えてますよという  ログを見るとこんなWarningが出力されています。
//     PHPではセキュリティなどの都合でリクエストの上限サイズが設定されています。
// 上限サイズを変更したい場合はphp.iniの設定を変更する必要があります。
// php.iniファイルを開いてpost_max_sizeを探します。post_max_size = 20M
// 大きなファイルをアップロードすると403になってしまったりする場合はこれが原因である場合が多いです。
// アップロード画像が php.ini　デフォルトだと upload_max_filesize = 2M  これも  upload_max_filesize = 30M  にするなど
// 2つの値を設定したらサーバーを再起動するのを忘れないように
// でも今回は、変更しません。The photo data failed to upload.　のエラーメッセージが出ますので、
//  resource/lang\en/validation.php ファイルを修正して日本語にします。

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // このほか、php.iniファイルの上限を超えると、The photo data failed to upload.　のエラーメッセージが出ます
            'photo_data' => [ 'nullable','file', 'image', 'max:1024', 'mimes:jpeg, png, jpg, tmp' ],

            'zip_number' => ['required', 'my_zip_regex'],
            //  値 'my_zip_regex' は  ValidatorServiceProvider クラスで作ったルール名

            'name' => ['required', 'string', 'max:255' ],
            'age' => [ 'required' , 'numeric', 'between:0,150' ],
            // 性別のラジオボタンはテンプレートのほう（Formファザード）には、required属性はつけないでおく
            'gender' => [ 'required' ,'string', 'size:1', 'in:男,女' ],

            'pref' => [ 'required' ,'string'],
            'address1' => [ 'required' ,'string' ],
            'address2' => [ 'required' ,'string'],
            'address3' => [ 'required' ,'string'],
            'department_id' => [ 'required','string' ],
            'hire_date' => [ 'required', 'date' ],
            'retire_date' => [ 'nullable', 'date', 'after_or_equal:hire_date' ],
        ];
    }

    public function messages() {

        return  [

            'photo_data.file' => '画像ファイルを選んでください',
            'photo_data.image' => '画像ファイルを選んでください',
            'photo_data.max' => '1Mを超えています',
            'photo_data.mimes' => '画像ファイルは、jpeg png jpg のいずれかにして下さい',


            'name.required' => '名前は必ず入力してください',

            'name.max' => '名前は255字以内で記入してください',
            'age.required' => '年齢は必ず入力してください',
            'age.numeric' => '年齢は数値を入力してください',
            'age.between' => '年齢は0以上150以内で入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別を選択してください',
            'zip_number.required' => '郵便番号は必ず入力してください',

            'zip_number.my_zip_regex' => '郵便番号は 000-0000 の形式で入力してください',

            'pref.required' => '都道府県は必ず入力してください',
            'address1.required' => '住所(市区町村郡)は必ず入力してください',
            'address2.required' => '住所(町名番地)は必ず入力してください',
            'address3.required' => '住所(建物名)は必ず入力してください',
            'department_id.required' => '所属を選択してください',
            'hire_date.required' => '入社日は必ず入力してください',
            'hire_date.date' => '入社日は、日付の形式で入力してください',

            'retire_date.date' => '退社日は、日付の形式で入力してください',
            'retire_date.after_or_equal' => '退社日は、入社日以降の日付です',
        ];
    }
}
