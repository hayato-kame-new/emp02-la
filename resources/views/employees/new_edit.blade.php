@extends('layouts.myapp')

@php
    $label = "";
@endphp
@if($action === "add")
    @php
        $label = "新規作成";
    @endphp
@else
    @php
        $label = "編集";
    @endphp
@endif

@section('title', $label)

@section('menubar')
    @parent
    社員{{$label}}ページ
@endsection

@section('content')
    @if(count($errors) > 0)
        <p style="color:red;">入力に問題があります</p>
    @endif
    @if(isset($employee))
        @if($action === 'add')
            <h3>社員の{{$label}}ページ</h3>
        @else
            <h3>社員ID: {{$emp_id}} の{{$label}}ページ</h3>
        @endif
        {{-- フラッシュメッセージ リダイレクトされてくる セッションスコープから取り出す sessionメソッドの引数は、キー --}}
        @if(session('f_message'))
            <p class="notice">
                メッセージ: {{session('f_message')}}
            </p>
        @endif
        <div class="toolbar">
            {!! link_to_route('employees.index', '社員一覧ページへ戻る', [] ) !!}
        </div>
        {{-- employeeのフォームですが、まず、親のデータが動かせるようになってから、 --}}
        {{-- laravelcollectiveを使用してる場合、 'files' => true とすれば、 フォームはファイルのアップロードをサポートします。 --}}
        {{-- 'method' => 'post'  は、 postなので、省略もできます --}}
        {!! Form::model($employee, ['route' => ['employees.emp_control', $employee->employee_id], 'method' => 'post', 'files' => true]) !!}
            {{-- hiddenフィールドで3つ送る --}}
            {!! Form::hidden('action', $action) !!}
            {!! Form::hidden('photo_id', $employee->photo_id) !!}
            {!! Form::hidden('employee_id', $employee->employee_id) !!}


            <div class="form-group form-inline row">
                {!! Form::label('name', '名前:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {!! Form::text('name', $employee->name, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('age', '年齢:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {!! Form::text('age', $employee->age, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('gender', '性別:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {!! Form::text('gender', $employee->getStringGender($employee->gender), ['class' => 'col-sm-9 form-control']) !!}
            </div>


            {{-- まず、photoテーブルに関するものだけ、表示、変更、アップロードできるか --}}
            {{-- 写真の表示と、画像ファイルのアップロード --}}
            @php
                // dd(isset($employee->photo->photo_data));
                // dd($action);
            @endphp
            {{-- ここから写真の表示 バイナリーデータがあったら表示する isset関数 で条件分岐する  新規だと、いつもない 編集では、必須ではないので、ない場合もある --}}
            @if(isset($employee->photo->photo_data))
                <div class="row mt-4">
                    <figure class="offset-3 col-sm-9">
                        <img src="data:{{$employee->photo->mime_type}};base64,{{$employee->photo->photo_data}}" alt="写真" title="社員の写真" width="250" height="250">
                    </figure>
                </div>
            @endif
            {{-- ここまで写真 --}}
            {{-- ここから画像のアップロード 　Form::model の  'files' => true  の設定が必要です --}}
            <div class="form-group form-inline row">
                {!! Form::label('photo_data', '写真:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {{-- Form::file を使い、 ファイル部品の場合は .form-control の代わりに .form-control-file を指定します。 初期値は null でいいのかな  --}}
                {!! Form::file('photo_data', null, ['class' => 'col-sm-9 form-control-file', 'accept' => ".jpeg, .jpg, .png, .tmp" ]) !!}
                {!! Form::hidden('photo_id', $employee->photo_id) !!}
            </div>
            {{-- ここまで 画像のアップロード --}}


            <small>※ 000-0000 の形式で入力してください</small><br>
            <div class="form-group form-inline row">
                {!! Form::label('zip_number', '郵便番号:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {!! Form::text('zip_number', $employee->zip_number, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            @php
                $pref_array = ['', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'];
            @endphp

            <div class="form-group form-inline row">
                {!! Form::label('pref', '都道府県:', ['class' => 'col-sm-3 col-form-label', ]) !!}
                {!! Form::select('pref', $pref_array, $employee->pref, ['class' => 'form-control ', 'placeholder' => '選択してください']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('address1', '住所1(市区町村郡):', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::text('address1', $employee->address1, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('address2', '住所2(町名番地):', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::text('address2', $employee->address2, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('address3', '住所3(建物名や番号):', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::text('address3', $employee->address3, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            {{-- employeesテーブルには、　'department_id'カラムしかない 表示を部署名にする 外部キー制約で、departmentプロパティとしてアクセルできるようになってるので  --}}
            <div class="form-group form-inline row">
                {!! Form::label('department_id', '所属:', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::select('department_id', $dep_name_array, $employee->department_id, ['class' => 'form-control ', 'placeholder' => '選択してください']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('hire_date', '入社日:', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::date('hire_date', $employee->hire_date, ['class' => 'col-sm-9 form-control']) !!}
            </div>

            <div class="form-group form-inline row">
                {!! Form::label('retire_date', '退社日:', ['class' => 'col-sm-3 col-form-label']) !!}
                {!! Form::date('retire_date', $employee->retire_date, ['class' => 'form-dontrol']) !!}
            </div>


            {!! Form::submit('送信', ['class' => 'btn btn-primary', 'confirm' => 'この内容で送信しますか?']) !!}
        {!! Form::close() !!}


        <div style="margin-top: 10px;">
            {!! Form::open(['route' => ['employees.emp_control', $employee->employee_id], 'method' => 'post']) !!}
                {!! Form::hidden('action', 'cancel') !!}
                {!! Form::submit('キャンセル', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
        {{-- <button style="margin-top: 10px; margin-bottom: 10px;" type="button" class="btn btn-light" display="inline-block">
            {!! link_to_route('employees.emp_control', 'キャンセル', ['action' => 'cancel'] , ['style' => 'color: blue;']) !!}
        </button> --}}


    @endif
@endsection

@section('footer')
    copyright 2021 kameyama
@endsection
