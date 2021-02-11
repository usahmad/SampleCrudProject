@extends('layouts.main')
@section('content_title', 'Change Password')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Change Password</h3>
                    </div>
                    <hr>
                    <form action="{{route('change_password') }}" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="cc-payment" class="control-label mb-1">Old password</label>
                            <input id="cc-pament" name="old_password" type="password" class="form-control">
                        </div>
                        <div class="form-group has-success">
                            <label for="cc-name" class="control-label mb-1">New Password</label>
                            <input id="cc-name" required name="new_password" type="password" class="form-control cc-name">
                        </div>
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Repeat new password</label>
                            <input id="cc-number" required name="new_password_conf" type="password" class="form-control cc-number">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary" value="Submmit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
