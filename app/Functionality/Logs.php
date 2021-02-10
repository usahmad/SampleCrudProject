<?php

namespace App\Functionality;

use App\Models\Logs as LogsModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Logs
{

    public static function getInstance(): Logs
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        return (new LogsModel())->getItems($request->all());
    }
}
