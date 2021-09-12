{{-- @if(count($users) > 0) --}}
@if(isset($users))
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <p>ユーザー一覧</p>
            <table class="table ">
                <tr><th width="25%">ID</th><th>ユーザー名</th><th></th></tr>

                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                        @if($user == Auth::user())
                        {{-- 本人だったら、詳細ページに行けるボタンを表示する aリンクボタンになるので、GETです。クエリーパラメータで情報が送られる--}}
                            <button type="button" class="btn btn-light" display="inline-block">
                                {{-- パスが、http://localhost:8000/users/4 などになる web.phpのルーティング  resourceメソッド にしてあるので
                                    users/{user}  の {user} のところに  Auth::id() の返り値が入る
                                    php artisan route:list　のコマンドで、確認してみて  URI が users/{user} 　Name　が users.show になってる
                                    URIには、パラメータがあるので、第3引数は、['user' => Auth::id()]  の配列になってる
                                --}}
                                {!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach

            </table>
        </div>
    </div>
    <p>
    {{-- ページネーションのリンク --}}
    {{ $users->links('pagination::bootstrap-4') }}
    </p>
@endif



