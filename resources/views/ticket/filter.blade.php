<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="priority"
                                        class="form-control">
                                    <option value="">Выберите приоритет</option>
                                    @foreach(priorities() as $key => $priority)
                                        <option
                                            value="{{$key}}" {{$key === (int)request()->input('priority') ? 'selected' : ''}}>{{$priority}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="department_id"
                                        class="form-control">
                                    <option value="">Выберите департамент</option>
                                    @foreach($departments as $department)
                                        <option
                                            value="{{$department->id}}" {{$department->id === (int)request()->input('department_id') ? 'selected' : ''}}>{{$department->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="№ поручения/служебной записки" name="assignment"
                                       value="{{request()->input('assignment')}}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Инициатор"
                                       name="initiator"
                                       value="{{request()->input('initiator')}}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Тема" name="theme"
                                       value="{{request()->input('theme')}}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Исполнители" name="executedBy"
                                       value="{{request()->input('executedBy')}}"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Срок исполнения	от" name="execution_period_from"
                                       value="{{request()->input('execution_period_from')}}"
                                       class="form-control date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Срок исполнения	до" name="execution_period_to"
                                       value="{{request()->input('execution_period_to')}}"
                                       class="form-control date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Дата фактического исполнение от"
                                       name="execution_actual_from"
                                       value="{{request()->input('execution_actual_from')}}"
                                       class="form-control date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Дата фактического исполнение до"
                                       name="execution_actual_to"
                                       value="{{request()->input('execution_actual_to')}}"
                                       class="form-control date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Отсрочено от" name="delay_from"
                                       value="{{request()->input('delay_from')}}"
                                       class="form-control date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Отсрочено до" name="delay_to"
                                       value="{{request()->input('delay_to')}}"
                                       class="form-control date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Дата создания от" name="created_from"
                                       value="{{request()->input('created_from')}}"
                                       class="form-control date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Дата создания до" name="created_to"
                                       value="{{request()->input('created_to')}}"
                                       class="form-control date">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <input id="check_ticket1" name="isTrashed" value="1"
                                   type="checkbox" class="form-control-custom" {{request()->has('isTrashed') ? 'checked' : ''}}>
                            <label for="check_ticket1">Показать удалённые</label>
                        </div>
                        <div class="col-md-auto">
                            <input type="submit" value="Фильтр" class="btn btn-sm btn-primary">
                        </div>

                        <div class="col-md-auto">
                            <a href="{{route(\Illuminate\Support\Facades\Route::currentRouteName())}}"
                               class="btn btn-sm btn-danger">Сбросить фильтр</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
