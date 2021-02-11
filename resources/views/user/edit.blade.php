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
                <form class="form-horizontal" method="POST" action="{{ route('user.update', $item->id) }}" enctype='multipart/form-data'>
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Имя пользователя</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" required value=" {{$item->name}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="text" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label" for="user_types">Выбрать</label>
                        <div class="col-sm-10">
                            <select name="permissions[]" style="height: 500px" multiple class="form-control">
                                <option value="" selected="selected">Выберите привилегия</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route }}" {{in_array($route, $item->getPermissions()) ? 'selected' : ''}}>{{ $route }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @permission('user.update')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="submit" value="Добавить" class="btn btn-sm btn-primary">
                            </div>
                        </div>
                    </div>
                    @endpermission
                </form>
            </div>
        </div>
    </div>


@endsection
