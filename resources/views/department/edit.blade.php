@extends('layouts.main')
@section('title','Product create')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body card-block">
                <form action="{{route('department.update', $product->id)}}" id="form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="text-input" class=" form-control-label">Title</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" id="text-input" name="title" value="{{$product->title}}"  placeholder="Title" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="password-input" class=" form-control-label">Role</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <select name="measurement" class="form-control">
                                <option value="">Select measurement</option>
                                @foreach($measurements as $role => $measurement)
                                    <option value="{{$measurement}}" {{$measurement === $product->measurement ? "selected" : ''}}>{{$measurement}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-11">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
