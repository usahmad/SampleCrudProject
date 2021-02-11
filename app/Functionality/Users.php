<?php
namespace App\Functionality;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class Users
{

    const rules = [
        'name' => 'required',
        'permissions' => 'required'
    ];

    public static function getInstance(): Users
    {
        return new self();
    }

    public function getRouteNames(): array
    {
        return array_diff(array_keys(Route::getRoutes()->getRoutesByName()), \App\Functionality\Constants::excludedRoutes);
    }

    public function getList($request): LengthAwarePaginator
    {
        return (new User())->getItems($request->all());
    }

    public function getListItem($id)
    {
        return (new User())->getItem($id);
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
        if(is_array($callback)){
            return $callback;
        }
        (new Logs())->store(auth()->user()->id, 'user created', request()->ip());
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
            if(is_array($callback)){
                return $callback;
            }
            (new Logs())->store(auth()->user()->id, 'user updated', request()->ip());

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
            (new Logs())->store(auth()->user()->id, 'user deleted', request()->ip());
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
