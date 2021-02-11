<?php


namespace App\Http\Controllers;


use App\Functionality\Logs;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {
        $items = Logs::getInstance()->getList($request);
        return view('log.index', compact('items'));
    }

}
