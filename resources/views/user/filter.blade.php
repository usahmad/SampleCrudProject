<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="Имя пользователя" name="name"
                                       value="{{request()->input('name')}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-auto">
                            <input type="submit" value="Фильтр" class="btn btn-sm btn-primary">
                        </div>
                        <div class="form-group col-auto">
                            <a href="{{route(\Illuminate\Support\Facades\Route::currentRouteName())}}"
                               class="btn btn-sm btn-success">Очистить фильтр</a>
                        </div>
                        <div class="form-group col-auto">
                            <a href="{{route('user.create')}}" class="btn btn-sm btn-success">Добавить пользователя</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
