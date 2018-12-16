<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HiDisciplineController extends Controller
{

    public function getDiscipline(Request $request){
        $allotment = $request->get('allotment', null);
        $semester = $request->get('semester', null);

    }

}
