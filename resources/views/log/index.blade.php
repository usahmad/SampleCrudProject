@extends('layout.main')
@push('scripts')
    <link rel="stylesheet" href="{{asset('css/jqueryui.css')}}">
    <script src="{{asset('js/jqueryui.js')}}"></script>
    <script>
        $(function() {$("#date").datepicker({ dateFormat: 'dd-mm-yy' });});
    </script>
    <script src="{{asset('js/filter_zbrosser.js')}}"></script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Логи</h4>
            </div>
            @include('log.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Пользователь</th>
                            <th>Лог</th>
                            <th>IP</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $log)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>{{$log->user->name}}</td>
                                <td>{{$log->message}}</td>
                                <td>{{$log->ip}}</td>
                                <td>{{$log->getCreatedAt()}}</td>
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
