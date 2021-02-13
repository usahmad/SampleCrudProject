<?php
    /**
     * @var \App\Models\Ticket $item
     */
?>
@extends('layout.main')
@push('scripts')
    <script src="{{asset('custom/ticket_filter1.js')}}"></script>
    <script src="{{asset('js/filter_zbrosser.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/jqueryui.css')}}">
    <script src="{{asset('js/jqueryui.js')}}"></script>
    <script>
        $(function () {
            $(".date").datepicker({dateFormat: 'dd.mm.yy'});
        });
    </script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4>Добавить заявки</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('ticket.update', $item->id)}}"
                      enctype='multipart/form-data'>
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">№ поручения/служебной записки</label>
                        <div class="col-sm-10">
                            <input type="text" required name="assignment" value="{{$item->getAssignment()}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Департамент</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="department_id" class="form-control">
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{$department->id === $item->department_id ? "selected" : ""}}>
                                            {{$department->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Приоритет</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="priority" class="form-control">
                                    @foreach(priorities() as $key => $name)
                                        <option value="{{$key}}" {{$key === $item->priority ? "selected" : ""}}>
                                            {{$name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Инициатор</label>
                        <div class="col-sm-10">
                            <input type="text" required name="initiator" value="{{$item->getInitiator()}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Срок исполнения</label>
                        <div class="col-sm-10">
                            <input type="text" required name="execution_period" value="{{$item->getExecutionPeriod()}}" class="form-control date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Тема служебной записи</label>
                        <div class="col-sm-10">
                            <input type="text" required name="theme" value="{{$item->getTheme()}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Исполнители</label>
                        <div class="col-sm-10">
                            <input type="text" required name="executedBy" value="{{$item->getExecutedBy()}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Отметка об исполнении</label>
                        <div class="col-sm-10">
                            <input type="text" required name="markingComment" value="{{$item->getMarkingComment()}}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Срок исполнения</label>
                        <div class="col-sm-10">
                            <input type="text" required name="delay" value="{{$item->getDelay()}}" class="form-control date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-1 form-control-label">Срок исполнения</label>
                        <div class="col-sm-10">
                            <input type="text" required name="execution_actual" value="{{$item->getExecutionActual()}}" class="form-control date">
                        </div>
                    </div>


                    @permission('ticket.update')
                    <div class="form-group">
                        <input type="submit" value="Отредактировать" class="btn btn-sm btn-primary">
                    </div>
                    @endpermission
                    @permission('ticket.destroy')
                    <div class="form-group">
                        <a href="{{route('ticket.destroy', $item->id)}}" class="btn btn-sm btn-danger">Удалить</a>
                    </div>
                    @endpermission

                </form>
            </div>
        </div>
    </div>
@endsection
