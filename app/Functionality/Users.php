<?php

namespace App\Functionality;

use App\Models\Log;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Users
{
    const USER_LIST = 'name={key}@page={key}';
    const USER = 'id={key}';

    const rules = [
        'name'        => 'required|string|max:50',
        'permissions' => 'required|array'
    ];

    public static function getInstance(): Users
    {
        return new self();
    }

    public function getRouteNames(): array
    {
        return array_diff(array_keys(Route::getRoutes()->getRoutesByName()), Constants::excludedRoutes);
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

        $cache = Cache::tags('users')->get($cacheKey);

        if ($cache === null) {

            $cache = (new User())->getItems($request->all());
            Cache::tags('users')->put($cacheKey, $cache, now()->addDay());

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

        $cache = Cache::tags(['users', $id])->get($cacheKey);

        if ($cache === null) {
            $cache = (new User())->getItem($id);
            Cache::tags(['users', $id])->put($cacheKey, $cache, now()->addDay());
        }

        return $cache;
    }

    /**
     * @param array $params
     * @return array|int
     */
    public function store(array $params)
    {
        $validator = Validator::make($params, self::rules);
        if ($validator->fails())
            return 422;

        $callback = (new User())->storeItem($validator->getData());
        if (is_array($callback)) {
            return $callback;
        }
        (new Log())->store(auth()->user()->id, 'user created', request()->ip());
        Cache::tags('users')->flush();
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

            $callback = Users::getInstance()
                ->getListItem($id)
                ->storeItem($validator->getData());
            if (is_array($callback)) {
                return $callback;
            }

            (new Log())->store(auth()->user()->id, 'user updated', request()->ip());

            Cache::tags(['users', $id])->flush();


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
            (new Log())->store(auth()->user()->id, 'user deleted', request()->ip());
            Cache::tags('users')->flush();
            return 200;
        } catch (\Exception $e) {
            return [
                $e->getMessage(),
                $e->getLine(),
            ];
        }
    }

    public function change_password(array $params): int
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $validator = Validator::make($params, [
            'old_password'      => 'required',
            'new_password'      => 'required',
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
            (new Log())->store(Auth::user()->id, "Password changed", request()->ip());
            return 200;
        } else
            return 700;
    }
}
