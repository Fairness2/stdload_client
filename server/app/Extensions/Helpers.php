<?php
/**
 * Created by PhpStorm.
 * User: kuzminykh
 * Date: 03.12.2018
 * Time: 9:59
 */

namespace App\Extensions;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;

class Helpers
{
    public static function checkRoleUser($user_id, $role){
        $res = DB::table('ref_user_roles')
            ->leftJoin('roles', 'ref_user_roles.role_id', '=', 'roles.id')
            ->where([['roles.name', $role], ['ref_user_roles.user_id', $user_id]])
            ->get()->first();

        if ($res)
            return true;
        else
            return false;
    }

    public static function loggingRoute(Request $request){
        $params = [];

        $params['user_id'] = Auth::check() ? Auth::id() : null;
        $params['url'] = $request->path();
        $params['method'] = $request->method();
        $params['get'] = json_encode($request->query());
        $post = array_diff($request->input(), $request->query());
        unset($post['password'], $post['_token'], $post['old_password'], $post['password_confirmation']);
        $params['post'] = json_encode($post);
        $params['header'] = json_encode($request->header());
        if($ip = self::getClientIP()){
            $params['ip'] = $ip;
        }
        DB::table('logs.log_route')->insert($params);
    }

    /**
     * Returns client IP address
     * @access public
     * @return string
     */

    public static function getClientIP()
    {
        $ipaddress = '';
        if(isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];

        return $ipaddress;
    }

    public static function loggingDB($query){
        $res = DB::table('logs.log_query')
            ->insert(['query' => $query->sql, 'bindings' => json_encode($query->bindings)]);
    }


}