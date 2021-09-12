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

            {!! Form::model($user, ['route' => ['password.update', Auth::user()->id], 'method' => 'put']) !!}

                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <table class="table table-striped">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>

            {!! Form::close() !!}
        @endif
    @else

    @endif
@endsection

