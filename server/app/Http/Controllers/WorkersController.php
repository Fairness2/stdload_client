<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkersController extends Controller
{
    public function getWorkers(Request $request){
        $workers = DB::table('worker')
            ->select('fio', 'id')
            ->where('not_active', '<>', true)
            ->orWhere('not_active', null)
            ->orderBy('fio')->get()->all();
        return ['status' => true, 'data' => $workers];
    }
}
