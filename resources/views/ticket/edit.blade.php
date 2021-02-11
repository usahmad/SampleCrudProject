@extends('layouts.main')
@section('title','User create')
@section('menu')
    @include('user.menu')
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body card-block">
                <form action="{{route('user.update', $user->id)}}" id="form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @method('PUT')
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="text-input" class=" form-control-label">User Name</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" id="text-input" value="{{$user->name}}" name="name" placeholder="User Name" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="password-input" class=" form-control-label">Password</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="password" id="password-input" name="password" placeholder="Enter the password" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-2">
                            <label for="password-input" class=" form-control-label">Role</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($roles as $role => $name)
                                    <option value="{{$role}}" {{$role === $user->role ? 'selected' : ''}}>{{$name}}</option>
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
