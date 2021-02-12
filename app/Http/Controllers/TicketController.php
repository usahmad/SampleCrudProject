<?php

namespace App\Http\Controllers;

use App\Functionality\Departments;
use App\Functionality\Tickets;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $items = Tickets::getInstance()->getList($request);
        return view('ticket.index', compact('items'));
    }

    public function create()
    {
        $departments = Department::query()->get();
        return view('ticket.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $callback = Tickets::getInstance()->store($request->all());
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        else
            return back()->with('error', 'Не хватает данных');
    }

    public function edit($id)
    {
        $departments = Department::query()->get();
        $item = Tickets::getInstance()->getListItem((int)$id);
        return view('ticket.edit', compact('item', 'departments'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $callback = Tickets::getInstance()->update($request->all(), (int)$id);
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        elseif (is_array($callback)) {
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
        } else
            return back()->with('error', 'Не хватает данных');
    }

    public function show($id)
    {
        $item = Tickets::getInstance()->getListItem($id);
        return view('ticket.view', compact('item'));
    }

    public function delete($id): RedirectResponse
    {
        $callback = Tickets::getInstance()->delete($id);
        if ($callback === 200)
            return back()->with('success', 'Успешно');
        else
            return back()->with('error', sprintf('Ошибка: %s, На строке: %s', ...$callback));
    }
}
