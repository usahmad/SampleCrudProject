<?php


namespace App\Http\Controllers;

use App\Functionality\Departments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $items = Departments::getInstance()->getList($request);
        return view('department.index', compact('items'));
    }

    public function create()
    {
        return view('department.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $callback = Departments::getInstance()->store($request->all());
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        else
            return back()->with('error', 'Не хватает данных');
    }

    public function edit($id)
    {
        $item = Departments::getInstance()->getListItem((int)$id);
        return view('department.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $callback = Departments::getInstance()->update($request->all(), (int)$id);
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
        $callback = Departments::getInstance()->delete($id);
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        else
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
    }
}
