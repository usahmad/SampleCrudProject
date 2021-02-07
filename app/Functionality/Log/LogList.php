<?php

namespace App\Functionality\Log;

use App\Interfaces\ListInterface;
use App\Models\Logs;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LogList implements ListInterface
{
    public static function getInstance(): LogList
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        return (new Logs())->getItems($request->all());
    }

    public function getListItem($id)
    {
    }
}
