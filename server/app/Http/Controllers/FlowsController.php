<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlowsController extends Controller
{
    public function getFlows(Request $request){
        $allotment = $request->get('allotment', null);
        $flows = DB::table('flow')
            ->where('allotment_id', $allotment)->get()->all();
        return ['status' => true, 'data' => $flows];
    }
}
