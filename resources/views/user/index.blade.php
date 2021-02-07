@extends('layouts.main')
@section('title','User List')
@section('menu')
    @include('user.menu')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th>User name</th>
                            <th>Role</th>
                            <th>Date created</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $user)
                            <tr>
                                <td>{{($key + 1)}}</td>
                                <td>
                                    <a href="{{route('user.edit', $user->id)}}">{{$user->getName()}}</a>
                                </td>
                                <td>
                                    <a href="{{route('user.edit', $user->id)}}">{{$user->getRole()}}</a>
                                </td>
                                <td>
                                    <a href="{{route('user.edit', $user->id)}}">{{$user->getCreatedAt()}}</a>
                                </td>
                                <td>
                                    <a href="{{route('user.destroy', $user->id)}}" class="btn btn-danger">Deactivate</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <div class="col">
                        <nav aria-label="pagination example">
                            {{ $items->links('layouts.paginator', ['paginator' => $items]) }}
                        </nav>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
