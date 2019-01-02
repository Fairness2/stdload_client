<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Extensions\Helpers;

class NeedRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) //TODO проверка прав на редактирование клиентов
    {

        if (!Auth::check()){
            return redirect()->route('home');
        }
        $user = Auth::user();

        $res = Helpers::checkRoleUser($user->getAttribute('id'), $role);

        if (!$res)
            return redirect()->route('home');

        return $next($request);
    }
}
