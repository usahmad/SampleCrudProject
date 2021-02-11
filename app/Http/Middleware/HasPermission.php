<?php


namespace App\Http\Middleware;


use Closure;

class HasPermission
{
    public function handle($request, Closure $next)
    {
        $actions = $request->route()->getAction();
        return in_array($actions['as'], auth()->user()->getPermissions()) ? $next($request) : back()->with('error', 'Нету доступа');
    }
}
