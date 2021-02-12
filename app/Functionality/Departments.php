<?php

namespace App\Functionality;

use App\Models\Department;
use App\Models\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class Departments
{
    const rules = [
        'title' => 'required'
    ];

    public static function getInstance(): Departments
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        return (new Department())->getItems($request->all());
    }

    public function getListItem($id)
    {
        return (new Department())->getItem($id);
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, self::rules);
        if ($validator->fails())
            return 422;

        (new Department())->storeItem($validator->getData());
        (new Log())->store(auth()->user()->id, 'department created', request()->ip());
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
            return 200;
        } catch (\Exception $e) {

            return [
                $e->getMessage(),
                $e->getLine(),
            ];

        }
    }
}
