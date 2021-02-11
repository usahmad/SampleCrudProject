@extends('layout.main')
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>Отредактировать департамент</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('department.update', $item->id) }}" enctype='multipart/form-data'>
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Категория</label>
                        <div class="col-sm-10">
                            <input type="text" required name="title" value="{{$item->title}}" class="form-control">
                        </div>
                    </div>
                    @permission('department.update')
                        <div class="form-group">
                            <input type="submit" value="Отредактировать" class="btn btn-sm btn-primary">
                        </div>
                    @endpermission
                </form>
            </div>
        </div>
    </div>
@endsection
