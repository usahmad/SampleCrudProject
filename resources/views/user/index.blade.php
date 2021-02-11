@extends('layout.main')
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Список пользователей</h4>
            </div>
            @include('user.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Created AT</th>
                            <th>Deactivate</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $user)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td><a href="{{route('user.edit', $user->id)}}">{{$user->getName()}}</a></td>
                                <td>
                                    <ul>
                                        @foreach($user->getPermissions() as $permission)
                                            <li>{{$permission}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td><a href="{{route('user.edit', $user->id)}}">{{$user->getCreatedAt()}}</a></td>
                                <td>
                                    @permission('user.destroy')
                                        <a href="{{route('user.destroy', $user->id)}}" class="btn btn-danger">Удалить</a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            <nav aria-label="pagination example">
                                {{ $items->links('shared.pagination', ['paginator' => $items]) }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
