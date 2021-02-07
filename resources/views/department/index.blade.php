@extends('layouts.main')
@section('title','User List')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th>title</th>
                            <th>measurement</th>
                            <th>Date created</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $product)
                            <tr>
                                <td>{{($key + 1)}}</td>
                                <td>
                                    <a href="{{route('department.edit', $product->id)}}">{{$product->title}}</a>
                                </td>
                                <td>
                                    <a href="{{route('department.edit', $product->id)}}">{{$product->measurement}}</a>
                                </td>
                                <td>
                                    <a href="{{route('department.edit', $product->id)}}">{{$product->getCreatedAt()}}</a>
                                </td>
                                <td>
                                    <a href="{{route('department.destroy', $product->id)}}" class="btn btn-danger">Deactivate</a>
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
