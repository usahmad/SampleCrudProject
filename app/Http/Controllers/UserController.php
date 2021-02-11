<?php


namespace App\Http\Controllers;

use App\Functionality\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $items = Users::getInstance()->getList($request);
        return view('user.index', compact('items'));
    }

    public function create()
    {
        $routes = Users::getInstance()->getRouteNames();
        return view('user.create', compact('routes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $callback = Users::getInstance()->store($request->all());
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        elseif (is_array($callback))
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
        else
            return back()->with('error', 'Не хватает данных');
    }

    public function edit($id)
    {
        $item = Users::getInstance()->getListItem((int)$id);
        $routes = Users::getInstance()->getRouteNames();

        return view('user.edit', compact('item', 'routes'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $callback = Users::getInstance()->update($request->all(), (int)$id);
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        elseif (is_array($callback)){
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
        }
        else
            return back()->with('error', 'Не хватает данных');
    }

    public function show($id): RedirectResponse
    {
        return $this->delete($id);
    }

    public function delete($id): RedirectResponse
    {
        $callback = Users::getInstance()->delete($id);
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        else
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
    }
}
