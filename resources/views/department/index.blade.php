@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Департаменты</h4>
            </div>
            <a href="{{route('department.create')}}" class="btn btn-sm btn-primary">Добавить</a>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Департамент</th>
                            <th>&ensp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $department)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>
                                    <a href="{{route('department.edit', $department->id)}}">{{$department->title}}</a>
                                </td>
                                <td>
                                    @permission('department.destroy')
                                    <a href="{{route('department.destroy', $department->id)}}"
                                       class="btn btn-sm btn-danger">Удалить</a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
