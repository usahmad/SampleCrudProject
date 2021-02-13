<?php

namespace App\Functionality;

use App\Models\Log as LogsModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Logs
{

    const LOGS = 'user_id={key}@message={key}@ip={key}@page={key}';

    public static function getInstance(): Logs
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $request->input('user_id'),
                $request->input('message'),
                $request->input('ip'),
                (0 === (int)$request->query('page')) ? 1 : (int)$request->query('page')
            ],
            self::LOGS
        );

        $cache = Cache::tags('logs')->get($cacheKey);

        if ($cache === null) {

            $cache = (new LogsModel())->getItems($request->all());
            Cache::tags('logs')->put($cacheKey, $cache, now()->addDay());

        }

        return $cache;
    }
}
