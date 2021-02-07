<?php

namespace App\Functionality\User;

use App\Interfaces\StoreInterface;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserStore implements StoreInterface
{
    protected $rules = [
        'name' => 'required',
        'password' => 'required'
    ];


    public static function getInstance(): UserStore
    {
        return new self();
    }


    public function store(array $params): int
    {
        $validator = Validator::make($params, $this->rules);
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
        $validator = Validator::make($params, ['name' => 'required']);

        if ($validator->fails())
            return 422;

        try {

            UserList::getInstance()
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

    public function change_password(array $params)
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
            (new Logs())->store(Auth::user()->id, "Password changed", request()->ip());
            return 200;
        } else
            return 700;
    }
}
