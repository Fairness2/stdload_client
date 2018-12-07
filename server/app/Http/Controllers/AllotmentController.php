<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllotmentController extends Controller
{
    public function getAllotments(Request $request){
        $allotments = DB::table('allotment')->where('is_remove', '<>', true)->orderBy('id')->get()->all();

        foreach ($allotments as &$allotment){
            $all_hours = DB::table('load_element')->where('allotment_id', $allotment->id)->sum('hours_planed');
            $dis_hours = DB::table('distribution_element')
                ->leftJoin('load_element', 'distribution_element.load_element_id','=', 'load_element.id')
                ->where('load_element.allotment_id', $allotment->id)->sum('load_element.hours_planed');

            $allotment->all_hours = $all_hours;
            $allotment->dis_hours = $dis_hours;
        }

        return ['status' => true, 'data' => $allotments];
    }

    public function addAllotment(Request $request){
        $fields = $request->only('name', 'year_begin', 'year_end');
        $res = DB::table('allotment')->insert($fields);
        return ['status' => (boolean)$res];
    }

    public function editAllotment(Request $request){
        $fields = $request->only('id', 'name', 'year_begin', 'year_end', 'is_main');
        if (!$fields['id'])
            return ['status' => false];
        $data = [];
        if (isset($fields['name']))
            $data['name'] = $fields['name'];
        if (isset($fields['year_begin']))
            $data['year_begin'] = $fields['year_begin'];
        if (isset($fields['year_end']))
            $data['year_end'] = $fields['year_end'];
        if (isset($fields['is_main']))
            $data['is_main'] = $fields['is_main'];

        $res = DB::table('allotment')->where('id', $fields['id'])->update($data);
        return ['status' => (boolean)$res];
    }

    public function removeAllotment(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];
        $res = DB::table('allotment')->where('id', $id)->update(['is_remove' => true]);
        return ['status' => (boolean)$res];
    }
}
