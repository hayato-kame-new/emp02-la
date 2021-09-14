@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
    @parent
    部署一覧ページ
@endsection

@section('content')
    {{-- @if(count($departments) > 0) --}}
    @if(isset($departments))
        <div class="row">
            <div class="col-sm-7 offset-sm-2">
                <table class="table table-striped">
                <thead>
                <tr><th width="25%">部署ID</th><th>部署名</th><th colspan="2"></tr>
                </thead>
                <tbody>
                    @foreach ($departments as $dep)
                        <tr>
                            <td>{{$dep->department_id}}</td>
                            <td>{{$dep->department_name}}</td>
                            <td>
                                {{--
                                    HTTPメソッドをフォームでGETにすると、クエリー文字列として、URLにくっついて送ります
                                     aリンクで送ったのと同じになります
                                     ルーティングは、 パラメータ付きのパスにしておいたから
                                     Route::get('/departments/new_edit/{dep_id}', [DepartmentsController::class, 'new_edit'])->name('departments.new_edit');

                                     php artisan route:list  で確認すると
                                    GET|HEAD  | departments/new_edit/{dep_id}    | departments.new_edit

                                    'route' => ['departments.new_edit', $dep->department_id  の、
                                    $dep->department_id　は、  {dep_id}  の値になるので、コントローラでは $request->dep_id  で取得できる
                                    http://localhost:8000/departments/new_edit/D02?action=edit
                                    パラメータの D02 が  departments/new_edit/{dep_id}  の {dep_id} の値として送られてる
                                        --}}
                                {!! Form::model('$dep', ['route' => ['departments.new_edit', $dep->department_id], 'method' => 'get']) !!}

                                    {!! Form::hidden('action', 'edit') !!}
                                     {{-- 部署IDは、下のようにhiddenで送ってもいい --}}
                                    {{-- {!! Form::hidden('department_id', $dep->department_id) !!} --}}
                                    {!! Form::submit('編集', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            </td>
                            <td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                </table>
            </div>
        </div>
    @else
    {{-- 部署がひとつもなかった。 --}}
    <p>現在登録されている部署はありません</p>
    @endif
    <div class="row">
        <div class="col-sm-7 offset-sm-2 mt-3 mb-3">
            {{-- 新規登録  ボタンリンクをクリックする aリンクは HTTPメソッドが、getです --}}
            <button type="button" class="btn btn-light" display="inline-block">

                {{-- {!! link_to_route('departments.new_edit', '部署新規作成ページ', ['action' => 'add'], ['style' => 'color: blue;']) !!} --}}


                {{--
                    link_to_route だと、第一引数は、->name('departments.new_edit') でつけた名前です
                    link_to_route('route.name', $title, $parameters = array(), $attributes = array())
                    第3引数の　　'action' => 'add'　は、 クエリー文字列の指定です
                    http://localhost:8000/department/new_edit?action=add 　
                    ?以降のクエリー文字列を設定をしてます
                    第4引数は 属性です aタグに関する属性を設定できる
                    link_to でも大丈夫です。{dep_id?} は、 ?がついてるので、任意パラメータだから。なくても大丈夫
                    注意 link_to の 第3引数は、パラメータではなく、属性の設定ですので、
                    パスの末尾に ? 以降のクエリーパラメータで送るようにしてください。link_to と、 link_to_route は、書き方が全く違うので注意
                    link_to('foo/bar', $title, $attributes = array(), $secure = null)
                    Route::get('/departments/new_edit/{dep_id?}', [DepartmentsController::class, 'new_edit'])->name('departments.new_edit');
                    --}}

                    {!! link_to('departments/new_edit?action=add', '部署新規作成ページ', ['style' => 'color: navy;'],  $secure = null) !!}

                </button>
        </div>
    </div>

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
