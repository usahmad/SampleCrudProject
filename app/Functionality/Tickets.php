<?php


namespace App\Functionality;


use App\Models\Logs;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class Tickets
{

    const rules = [
        'priority' => 'required',
        'department_id' => 'required',
        'assignment' => 'required',
        'initiator' => 'required',
        'theme' => 'required',
        'executedBy' => 'required',
        'markingComment' => 'required',
        'execution_period' => 'required',
    ];

    public static function getInstance(): Tickets
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        return (new Ticket())->getItems($request->all());
    }

    public function getListItem($id)
    {
        return (new Ticket())->getItem($id);
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, self::rules);
        if ($validator->fails())
            return 422;

        (new Ticket())->storeItem($validator->getData());
        (new Logs())->store(auth()->user()->id, 'ticket created', request()->ip());
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
            (new Logs())->store(auth()->user()->id, 'ticket updated', request()->ip());

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
            self::getInstance()->getListItem($id)->delete();
            return 200;
        } catch (\Exception $e) {
            return [
                $e->getMessage(),
                $e->getLine(),
            ];
        }
    }
}
