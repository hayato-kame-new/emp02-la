@extends('layouts.myapp')

@section('title', 'Password')

@section('menubar')
    @parent
    ユーザーパスワード編集ページ
@endsection

@section('content')
    @if(Auth::check())
        @if(isset($user))

            <h3>{{ $user->name }}さんのパスワード編集ページ</h3>

            @if(session('flash_message'))
                <p class="notice">
                    メッセージ:{{ session('flash_message') }}
                </p>
            @endif

            <div class="toolbar">
                {!! link_to_route('users.show', 'ユーザー詳細ページへ戻る', ['user' => Auth::user()->id]) !!}
            </div>
            {{--
            php artisan route:list  コマンドで確認する

            Method       |    URI                              | Name
            PUT|PATCH    |    password/{password}              | password.update

            パラメータ  {password}  の ところに  Auth::user()->id  が入る  Auth::id()  でもいい
            パラメータの  {}の中の  password  が キー   Auth::id()が値になる
            パラメータの値は、コントローラでは、 $request->パラメータのキー  で　値を取得できます
            また、ルーティングが resourceなので、 'method' は、 'post'　じゃなくて 'put' です
            http://localhost:8000/password/51
            --}}
            {!! Form::model($user, ['route' => ['password.update', Auth::user()->id], 'method' => 'put']) !!}

                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <table class="table table-striped">
                            <tr>
                                <td>{!! Form::label('current_password', '現在のパスワード') !!}</td>
                                <td>{!! Form::password('current_password', ['class' => 'form-control']) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('password', '新しいパスワード') !!}</td>
                                <td>{!! Form::password('password', ['class' => 'form-control']) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('password_confirmation', '確認のための新しいパスワードを入力') !!}</td>
                                <td>{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}</td>
                            </tr>
                        </table>
                        <div>
                            {!! Form::submit('変更', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        @endif
    @else
    {{-- ログインしてない --}}
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
    @endif
@endsection

@section('footer')
    copyright 2021 kameyama
@endsection
