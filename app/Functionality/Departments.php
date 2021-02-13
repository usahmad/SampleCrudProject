<?php

namespace App\Functionality;

use App\Models\Department;
use App\Models\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Departments
{
    const DEPARTMENT_LIST = 'title={key}@page={key}';
    const DEPARTMENT = 'id={key}';


    const rules = [
        'title' => 'required|string|max:50'
    ];

    public static function getInstance(): Departments
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $request->input('title'),
                (0 === (int)$request->query('page')) ? 1 : (int)$request->query('page')
            ],
            self::DEPARTMENT_LIST
        );

        $cache = Cache::tags('department')->get($cacheKey);

        if ($cache === null) {
            $cache = (new Department())->getItems($request->all());
            Cache::tags('department')->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }

    public function getListItem($id): Department
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $id
            ],
            self::DEPARTMENT
        );

        $cache = Cache::tags(['department', $id])->get($cacheKey);

        if ($cache === null) {

            $cache = (new Department())->getItem($id);
            Cache::tags(['department', $id])->put($cacheKey, $cache, now()->addDay());

        }

        return $cache;
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, self::rules);

        if ($validator->fails())
            return 422;

        (new Department())->storeItem($validator->getData());
        (new Log())->store(auth()->user()->id, 'department created', request()->ip());
        Cache::tags('department')->flush();

        return 200;
    }

    /**
     * @param array $params
     * @param $id
     * @return array|int
     */
    public function update(array $params, $id)
    {
        $validator = Validator::make($params, self::rules);

        if ($validator->fails())
            return 422;

        try {

            self::getInstance()
                ->getListItem($id)
                ->storeItem($validator->getData());
            (new Log())->store(auth()->user()->id, 'department updated', request()->ip());

            Cache::tags(['department', $id])->flush();

        } catch (\Exception $exception) {
            return [
                $exception->getMessage(),
                $exception->getLine(),
            ];
        }

        return 200;
    }

    public function delete($id)
    {
        try {
            self::getInstance()
                ->getListItem($id)
                ->delete();

            (new Log())->store(auth()->user()->id, 'department deleted', request()->ip());

            Cache::tags('department')->flush();

            return 200;
        } catch (\Exception $e) {

            return [
                $e->getMessage(),
                $e->getLine(),
            ];

        }
    }
}
