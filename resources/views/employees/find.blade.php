@extends('layouts.myapp')

@section('title', 'Search')

@section('menubar')
   @parent
   社員検索ページ
@endsection

@section('content')
<div class="toolbar">{!! link_to_route('employees.index', '社員一覧へ戻る',[]) !!}</div>

<h3>条件を指定して社員情報を検索します。</h3>
    {{-- 'method' => 'post' は省略可 検索ボタンを押したら、検索処理を実行するので、'method' => 'post'　です  --}}
    {!! Form::open(['route' => ['employees.search' ], 'method' => 'post']) !!}

        <div class="form-group">
        {!! Form::label('department_id','所属:') !!}
        {!! Form::select('department_id',   $dep_name , null, ['class' => 'form-control' , 'placeholder' => '選択してください']); !!}
        </div>
        <div class="form-group">
        {!! Form::label('employee_id','社員ID:') !!}
        {!! Form::text('employee_id', null, ['class' => 'form-control' ]); !!}
        </div>
        <div class="form-group">
        {!! Form::label('word','名前に含む文字:') !!}
        {!! Form::text('word', null, ['class' => 'form-control' ]); !!}
        </div>

        {!! Form::submit('検索', ['class' => 'btn btn-primary' ]) !!}

    {!! Form::close() !!}


    @if (count($employees) > 0)
    <hr>
        <p style="color: blue"></p>
        <p style="color: red;">{{$result}}</p>
        @include('employees.employees')
    @else
    <hr>
        <p style="color: red;">{{$result}}</p>
    @endif
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
