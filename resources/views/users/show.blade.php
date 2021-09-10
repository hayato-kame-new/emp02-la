@extends('layouts.myapp')

@section('title', 'Show')

@section('menubar')
    @parent
    ユーザー詳細ページ
@endsection

@section('content')
    <div class="toolbar">
        {{--  link_to_routeの第一実引数は　例えば ->name('dashboard') 　で名前をつけたものを指定する
        ルーティング設定の際 resourceメソッドの時は、
        php artisan route:list　のコマンドで、確認してみる。 UsersControllerのindexアクションへのリンクは  URI が users 　Name　が users.index になってる
        URIには、パラメータがないので、第3引数は、からの配列になってる --}}
        {!! link_to_route('users.index', 'ユーザー一覧へ戻る', []) !!}
    </div>


@endsection

@section('footer')
copyright 2021 kameyama
@endsection
