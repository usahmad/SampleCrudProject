<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="Лог" name="message" value="{{request()->input('message')}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <div class="form-group">
                                <input type="submit" value="Фильтр" id="filter" class="btn btn-sm btn-primary">
                            </div>
                            <div class="form-group">
                                <input type="button" id="reset" value="Сбросить фильтр" class="btn btn-sm btn-success">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
