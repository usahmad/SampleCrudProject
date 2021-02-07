<?php
namespace App\Functionality\User;
use App\Interfaces\ListInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UserList implements ListInterface
{

    const USER_LIST = 'user@name={key}@page={key}';
    const USER = 'user@id = {key}';

    public static function getInstance(): UserList
    {
        return new self();
    }

    public function getList($request): LengthAwarePaginator
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $request->input('name'),
                (0 === (int)$request->query('page')) ? 1 : (int)$request->query('page')
            ],
            self::USER_LIST
        );
        $cache = Cache::tags('user')->get($cacheKey);
        if (is_null($cache)){
            $cache = (new User())->getItems($request->all());
            Cache::tags('user')->put($cacheKey, $cache, now()->addDay());
        }
        return $cache;
    }

    public function getListItem($id): User
    {
        $cacheKey = Str::replaceArray(
            '{key}',
            [
                $id
            ],
            self::USER
        );
        $cache = Cache::tags('user')->get($cacheKey);
        if (is_null($cache)){
            $cache = (new User())->getItem($id);
            Cache::tags('user')->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }
}
