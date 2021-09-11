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
    {{-- @if (Auth::check()) @else  @endif  と同じ意味の  @auth  @else  @endauth  --}}
    {{--  @auth @else @endauthは、ミドルウェアで'middleware' => 'auth'　をつけてるから本当はいらないかも --}}
    @auth
        @if(isset($user))
        {{-- isset関数は 変数に値が入っていて かつNULL（空っぽ）ではないときに true --}}
        <h3>{{$user->name}}さんの詳細ページ</h3>
        <table class="table table-striped">
            <tr>
                <th>ID</th><th>名前</th><th>メールアドレス</th><th colspan="3"></th>
            </tr>
            <tr>
                <td>{{$user->id}}</td><td>{{$user->name}}</td><td>{{$user->email}}</td>
                {{-- もし、ログインしているユーザー自身なら、編集 削除ができる Auth::id() と Auth::user()->id は同じ --}}
                @if($user == Auth::user())
                <td>
                    <button type="button" class="btn btn-light" display="inline-block">
                        {!! link_to_route('users.edit', 'ユーザー情報編集', ['user' => Auth::id()]) !!}
                        {{-- 'user' => Auth::id()  でも  'user' => Auth::user()->id どっちでもいい
                        URIには、パラメータがあるので、　第3引数は、　['user' => Auth::id()]　　配列になってる
                        php artisan route:list　のコマンドで、確認してみると、ルーティングは resourceメソッドなので、
                        URI は、  users/{user}/edit   NAMEは、 users.edit
                        パラメータの {user} のところに入るのに、第3引数に ['user' => Auth::id()] または、['user' => Auth::user()->id]を入れてる
                        --}}
                    </button>
                </td>
                @endif
            </tr>
        </table>
        @endif
    {{-- ログインしてないなら --}}
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
