@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
    @parent
    ユーザー一覧ページ
@endsection

@section('content')
    <div class="toolbar">
        {{--  link_to_routeの第一実引数は　 ->name('dashboard') 　で名前をつけたものを指定する
        URIには、パラメータがないので、第3引数は、からの配列になってる --}}
        {!! link_to_route('dashboard', 'Dashboardへ戻る', []) !!}
    </div>
    {{-- ユーザ一覧のページを取り込んでる --}}
    @include('users.users')

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
