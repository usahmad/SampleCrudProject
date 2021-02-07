<?php


namespace App\Http\Controllers\Web;


use App\Functionality\Log\LogList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {
        $items = LogList::getInstance()->getList($request);
        return view('log.index', compact('items'));
    }

}
