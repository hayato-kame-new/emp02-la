@extends('layouts.myapp')

@section('title', 'Edit')

@section('menubar')
    @parent
    ユーザー情報編集ページ<small>メールアドレス以外</small>
@endsection

@section('content')
    @auth
    {{-- 自分だけが編集  削除  できるように　ログイン認証は、@auth @else @endauth  でもいいし  @if (Auth::check()) @else  @endif でもいい
        ミドルウェアで'middleware' => 'auth'　をつけてるから本当はいらないかも
        --}}
        @if(isset($user))
            <h3>{{$user->name}}さんの編集ページ</h3>

            <div class="toolbar">
                {!! link_to_route('users.show' , 'ユーザー詳細ページへ戻る', ['user' => Auth::user()->id]) !!}
            </div>


            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    {{-- UsersController@updateで、バリデーションしてますが、バリデーションエラーが発生した場合、自動的に元のこのページへリダイレクトされ、さらに $errors 変数にエラーメッセージが格納されます。
                        そのため、 View側で $errors があるか確認し、あれば表示するという処理を追加すればOKです。また、 $errors と複数形で書いてある通り、複数のエラーが保存されることもあります。--}}
                    @if (count($errors) > 0)
                        <ul class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <li class="ml-4">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {{--
                    フォームの送信の 第3引数'method' は、 resourceメソッドなので、'post' じゃなくて 'put' になる   'method' => 'put'
                    php artisan route:list コマンドで確認すると、
                    Method が  PUT|PATCH      URI が  users/{user}    Name が  users.update

                    第2引数 'route' は、['route' => ['users.update', Auth::user()->id]
                    users/{user}  の　{} のパラメータのところに、　Auth::user()->id　の返り値が入る  Auth::user()->id  は、 Auth::id() と同じです
                    http://localhost:8000/users/51   --}}
                    {!! Form::model($user, ['route' => ['users.update', Auth::user()->id ], 'method' => 'put']) !!}
                        <div class="form-group">
                            {!! Form::label('name', '名前:') !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'メールアドレス:') !!}
                            {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('更新', ['class' => 'btn btn-primary', 'confirm' => 'この内容で更新しますか?']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
    {{-- ログインしてないのに、このページにアクセスしてきたら  --}}
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
