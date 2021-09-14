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
    @endif
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
