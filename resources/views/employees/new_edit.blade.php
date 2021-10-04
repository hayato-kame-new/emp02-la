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
            {!! Form::submit('送信', ['class' => 'btn btn-primary', 'confirm' => 'この内容で送信しますか?']) !!}
        {!! Form::close() !!}
    @endif
@endsection

@section('footer')
    copyright 2021 kameyama
@endsection
