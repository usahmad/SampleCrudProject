@extends('layout.main')
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>Добавить пользователя</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('user.store') }}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Имя пользователя</label>
                        <div class="col-sm-10">
                            <input type="text" required name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="text" required name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row"><!-- Xose -->
                        <label class="col-sm-1 form-control-label" for="user_types">Выбрать</label>
                        <div class="col-sm-10">
                            <select name="permissions[]" style="height: 500px" multiple class="form-control">
                                <option value="" selected="selected">Выберите привилегия</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route }}">{{ $route }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="submit" value="Добавить" class="btn btn-sm btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
