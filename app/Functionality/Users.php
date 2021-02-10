<?php
namespace App\Functionality;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Users
{

    const USER_LIST = 'user@name={key}@page={key}';
    const USER = 'user@id={key}';
    const rules = [
        'name' => 'required'
    ];

    public static function getInstance(): Users
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
        if (is_null($cache)) {
            $cache = (new User())->getItem($id);
            Cache::tags('user')->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }

    public function store(array $params): int
    {
        $validator = Validator::make($params, self::rules);
        if ($validator->fails())
            return 422;

        (new User())->storeItem($validator->getData());
        (new Logs())->store(auth()->user()->id, 'user created', request()->ip());
        Cache::tags('user')->flush();
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

            Users::getInstance()
                ->getListItem($id)
                ->storeItem($validator->getData());
            Cache::tags('user')->flush();
            (new Logs())->store(auth()->user()->id, 'user updated', request()->ip());

        } catch (\Exception $exception) {
            return [
                $exception->getMessage(),
                $exception->getLine(),
            ];
        }

        return 200;
    }

    public function delete($id): int
    {
        try {
            User::query()->find($id)->delete();
            (new Logs())->store(auth()->user()->id, 'user deleted', request()->ip());
            Cache::tags('user')->flush();
            return 200;
        } catch (\Exception $e) {
            return 500;
        }
    }

    public function change_password(array $params): int
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $validator = Validator::make($params, [
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_conf' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return 422;
        }
        if (Hash::check($params['old_password'], $user->password)) {
            $user_id = $user->id;
            User::query()
                ->where('id', '=', $user_id)
                ->update(['password' => Hash::make($params['new_password'])]);
            (new Logs())->store(Auth::user()->id, "Password changed", request()->ip());
            return 200;
        } else
            return 700;
    }
}
