<?php

namespace App\Http\Controllers;

use App\Extensions\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('home');
    }

    public function getWorkers(Request $request){
        $workers = DB::table('worker')
            ->select('fio', 'id')
            ->where('not_active', '<>', true)
            ->orWhere('not_active', null)
            ->orderBy('fio')->orderBy('fio')->get()->all();
        return ['status' => true, 'data' => $workers];
    }

    public function getDisciplines(Request $request){
        $disciplines = DB::table('discipline')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $disciplines];
    }

    public function getTypesClass(Request $request){
        $disciplines = DB::table('type_class')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $disciplines];
    }

    public function getSpecialities(Request $request){
        $disciplines = DB::table('specialty')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $disciplines];
    }

    public function getCoef(Request $request){
        $type = $request->get('type',null);
        $sql = DB::table('coefficients');
        if ($type)
            $sql = $sql->where('type', $type);
        else
            $sql = $sql->whereIn('type', [2, 3]);

        if (!Helpers::checkRoleUser(Auth::id(), 'admin'))
            $sql = $sql->where('worker_id', Auth::id());

        $disciplines = $sql->get()->all();
        return ['status' => true, 'data' => $disciplines];
    }

}
