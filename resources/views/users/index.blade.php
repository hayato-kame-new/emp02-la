@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
    @parent
    ユーザー一覧ページ
@endsection

@section('content')
{{-- @authによってログインしてるユーザだけ見られる --}}
{{-- @auth @else @endauth は、ミドルウェアで'middleware' => 'auth'　をつけてるから本当はいらないかも --}}
    @auth
        <div class="toolbar">
            {{--  link_to_routeの第一実引数は　 ->name('dashboard') 　で名前をつけたものを指定する
            URIには、パラメータがないので、第3引数は、からの配列になってる --}}
            {!! link_to_route('dashboard', 'Dashboardへ戻る', []) !!}
        </div>
        {{-- ユーザ一覧のページを取り込んでる --}}

        @include('users.users')

    {{-- ログインしてなかったら ロクイン画面へ --}}
    @else
        <p>ログインしてください</p>
        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
        @endif
    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
