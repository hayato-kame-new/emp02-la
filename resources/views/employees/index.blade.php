@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
    @parent
    社員一覧ページ
@endsection

@section('content')

    <p>社員一覧:</p>
    @if(session('f_message'))
        <p class="notice">
            {{session('f_message')}}
        </p>
    @endif
    <div class="toolbar">
        {!! link_to_route('dashboard', 'Dashboardへ戻る', [] ) !!}
    </div>
    {{-- もし コレクションの中身の要素数が 0以上なら、テーブルを表示する --}}
    @if(count($employees) > 0)
        <div class="row">
            <div class="col-sm-10 offset-sm-1">
                <table class="table table-stripe">
                    <thead>
                        <tr>
                            <th>社員ID</th><th>名前</th><th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{$employee->employee_id}}</td>
                                <td>{{$employee->name}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" display="inline-block">
                                        {!! link_to_route('employees.new_edit', '編集', [ 'action' => 'edit', 'emp_id' => $employee->employee_id ], ['style' => 'color:white;']) !!}
                                    </button>
                                      {{-- Route::get('/employees/new_edit/{emp_id?}', [ EmployeesController::class, 'new_edit' ])->name('employees.new_edit'); --}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" display="inline-block" onclick='confirm("本当に削除してよろしいですか")'>
                                        {!! link_to_route('employees.delete', "削除", [ 'action' => 'delete', 'emp_id' => $employee->employee_id ], ['style' => 'color: white;'] ) !!}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  もし、buttonじゃなくてフォームにすると、hiddenを使うが button では、 クエリー文字列で送る --}}
    <button style="margin-top: 15px; margin-right: 15px;" type="button" class="btn btn-light" display="inline-block">
        {!! link_to_route('employees.new_edit', '社員新規作成ページ', ['action' => 'add',], ['style' => 'color:blue;']) !!}
    </button>
@endsection

@section('footer')
    copyright 2021 kameyama
@endsection
