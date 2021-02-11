@extends('layout.main')
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>Изменить пароль</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('change_password') }}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Старый пароль</label>
                        <div class="col-sm-10">
                            <input type="text" required name="old_password" class="form-control">
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Новый пароль</label>
                        <div class="col-sm-10">
                            <input type="text" required name="new_password" class="form-control">
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Повторите свой новый пароль</label>
                        <div class="col-sm-10">
                            <input type="text" required name="new_password_conf" class="form-control">
                        </div>
                    </div>
                    <div class="line"></div>
                    <br>
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
