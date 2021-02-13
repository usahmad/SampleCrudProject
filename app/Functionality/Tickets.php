<?php


namespace App\Functionality;


use App\Models\Log;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Tickets
{

    const TICKET_LIST = 'priority={key}
    @department_id={key}
    @assignment={key}
    @initiator={key}
    @theme={key}
    @executedBy={key}
    @execution_period_from={key}
    @execution_period_to={key}
    @execution_actual_from={key}
    @execution_actual_to={key}
    @delay_from={key}
    @delay_to={key}
    @created_from={key}
    @created_to={key}
    @isTrashed={key}
    @page={key}';
    const TICKET = 'id={key}';


    const rules = [
        'assignment'       => 'required|string|max:100',
        'priority'         => 'required|integer|max:5',
        'department_id'    => 'required|integer|max:10',
        'initiator'        => 'required|string|max:100',
        'theme'            => 'required|string|max:100',
        'executedBy'       => 'required|string|max:100',
        'execution_period' => 'required|string|max:100',
    ];

    public static function getInstance(): Tickets
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $request->input('priority'),
                $request->input('department_id'),
                $request->input('assignment'),
                $request->input('initiator'),
                $request->input('theme'),
                $request->input('executedBy'),
                $request->input('execution_period_from'),
                $request->input('execution_period_to'),
                $request->input('execution_actual_from'),
                $request->input('execution_actual_to'),
                $request->input('delay_from'),
                $request->input('delay_to'),
                $request->input('created_from'),
                $request->input('created_to'),
                $request->has('isTrashed'),
                (0 === (int)$request->query('page')) ? 1 : (int)$request->query('page')
            ],
            self::TICKET_LIST
        );

        $cache = Cache::tags('ticket')->get($cacheKey);

        if ($cache === null) {
            $cache = (new Ticket())->getItems($request->all());
            Cache::tags('ticket')->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }

    public function getListItem($id): Ticket
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $id
            ],
            self::TICKET
        );

        $cache = Cache::tags(['ticket', $id])->get($cacheKey);

        if ($cache === null) {

            $cache = (new Ticket())->getItem($id);
            Cache::tags(['ticket', $id])->put($cacheKey, $cache, now()->addDay());

        }

        return $cache;
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, self::rules);
        if ($validator->fails())
            return 422;

        (new Ticket())->storeItem($validator->getData());
        (new Log())->store(auth()->user()->id, 'ticket created', request()->ip());

        Cache::tags('ticket')->flush();

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

            (new Log())->store(auth()->user()->id, 'ticket updated', request()->ip());

            Cache::tags(['ticket', $id])->flush();

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
            Cache::tags('ticket')->flush();
            return 200;
        } catch (\Exception $e) {
            return [
                $e->getMessage(),
                $e->getLine(),
            ];
        }
    }
}
