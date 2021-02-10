<?php


namespace App\Functionality;


use App\Models\Logs;
use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Tickets
{

    const TICKET_LIST = 'ticket@title={key}@page={key}';
    const TICKET = 'ticket@id={key}';
    const rules = [
        'title' => 'required'
    ];

    public static function getInstance(): Tickets
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
            self::TICKET_LIST
        );
        $cache = Cache::tags('ticket')->get($cacheKey);
        if (is_null($cache)) {
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
        if (is_null($cache)) {
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
        (new Logs())->store(auth()->user()->id, 'department created', request()->ip());
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
            Cache::tags(['ticket', $id])->flush();
            (new Logs())->store(auth()->user()->id, 'department updated', request()->ip());

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
