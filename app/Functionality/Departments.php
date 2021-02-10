<?php

namespace App\Functionality;

use App\Models\Department;
use App\Models\Logs;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Departments
{
    const DEPARTMENT_LIST = 'department@title={key}@page={key}';
    const DEPARTMENT = 'department@id={key}';

    const rules = [
        'title' => 'required'
    ];

    public static function getInstance(): Departments
    {
        return new self();
    }

    public function getList($request)
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
        if (is_null($cache)){
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
        if (is_null($cache)) {
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
        (new Logs())->store(auth()->user()->id, 'department created', request()->ip());
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
            Cache::tags(['department', $id])->flush();
            (new Logs())->store(auth()->user()->id, 'department updated', request()->ip());

        } catch (\Exception $exception) {
            return [
                $exception->getMessage(),
                $exception->getLine(),
            ];
        }

        return 200;
    }}
