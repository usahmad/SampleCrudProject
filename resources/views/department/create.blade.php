@extends('layout.main')
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>Добавить департамент</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('department.store')}}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Название</label>
                        <div class="col-sm-10">
                            <input type="text" required name="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Добавить" class="btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
