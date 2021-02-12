<?php
/**
 * @var \App\Models\Ticket $ticket
 */
?>
@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Заявки</h4>
            </div>
            <a href="{{route('ticket.create')}}" class="btn btn-sm btn-primary">Добавить</a>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>№ поручения/служебной записки</th>
                            <th>Приоритет</th>
                            <th>Инициатор</th>
                            <th>Дата создания</th>
                            <th>Срок исполнения</th>
                            <th>Отсрочено до</th>
                            <th>Дата фактического исполнения</th>
                            <th>Тема служебной записи</th>
                            <th>Отдел</th>
                            <th>Исполнители</th>
                            <th>Отметка об исполнении</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $ticket)
                            <tr>
                                <td>{{$ticket->getAssignment()}}</td>
                                <td>{{$ticket->getPriority()}}</td>
                                <td>{{$ticket->getInitiator()}}</td>
                                <td>{{$ticket->getCreatedAt()}}</td>
                                <td>{{$ticket->getExecutionPeriod()}}</td>
                                <td>{{$ticket->getDelay()}}</td>
                                <td>{{$ticket->getExecutionActual()}}</td>
                                <td>{{$ticket->getTheme()}}</td>
                                <td>{{$ticket->getDepartment()}}</td>
                                <td>{{$ticket->getExecutedBy()}}</td>
                                <td>{{$ticket->getMarkingComment()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
