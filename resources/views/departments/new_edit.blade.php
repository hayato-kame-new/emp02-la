@extends('layouts.myapp')

@php
    $title = '';
    $title_japanese = '';
    if($action == 'add') {
        $title = 'New';
        $title_japanese = '新規';
    } else if($action == 'edit'){
        $title = 'Edit';
        $title_japanese = '編集';
    }
    @endphp

@section('title', $title)

@section('menubar')
    @parent
    部署{{$title_japanese}}ページ
@endsection

@section('content')
    {{-- 'method' => 'post' にしたので、リクエストボディ（本体）に情報が載る
    フォーム送信先のパスは、必須パラメータ付き   のルーティングになってる
    {}のパラメータの名前（キー）に、? が無いので 必須パラメータです
            Route::post('/departments/create_update/{dep_id}',[DepartmentsController::class, 'create_update'])->name('departments.create_update');
    この {dep_id} には、 ? が無いので、必須パラメータです。
    $department と　$action の変数は、new_editアクションから、パラメータで送られてきてる。
    'route' => ['departtments.create_update', $department->department_id]  の、$department->department_id　は、
    {dep_id} の　パラメータの値になりますので、送信先のupdateアクションでは、
    $request->キー　で取得できますから、 $request->dep_id で、　値の $department->department_id が取得できる

    --}}
    {!! Form::model($department, ['route' => ['departments.create_update', $department->department_id], 'method' => 'post']) !!}

        <div class="form-group form-inline row">
            {!! Form::label('department_name', '部署名: ', ['class' => 'col-sm-3 col-form-label']) !!}
            {{-- textの第2引数は、デフォルト値初期値になります。新規の時には、null となります --}}
            {!! Form::text('department_name', $department->department_name, ['class' => 'form-control col-sm-8']) !!}
        </div>

        {!! Form::hidden('action', $action) !!}
        <div class="row">
        {!! Form::submit('送信', ['class' => 'btn btn-secondary offset-3', 'confirm' => 'この内容で送信しますか？']) !!}
        </div>
        {!! Form::close() !!}
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
