<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadElementController extends Controller
{
    public function setLoadElement(Request $request){
        $id = $request->get('id', null);
        $flow = $request->get('thread', null);
        $classroom = $request->get('classroom', null);
        $needInteractiveBoard = $request->get('need_interactive_board', false);
        $needMultimediaClassroom = $request->get('need_multimedia_classroom', false);
        $needMarkerBoard = $request->get('need_marker_board', false);
        $comment = $request->get('comment', null);
        $hoursFirstBefore = $request->get('hours_first_before', null);
        $hoursSecondBefor = $request->get('hours_second_befor', null);
        $foursFirstAfter = $request->get('fours_first_after', null);
        $hoursSecondAfter = $request->get('hours_second_after', null);
        if ($id === null){
            return ['status' => false];
        }

        $res = DB::table('load_element')->where('id', $id)->update([
            'flow_id' => $flow,
            'classroom_id' => $classroom,
            'need_interactive_board' => $needInteractiveBoard,
            'need_multimedia_classroom' => $needMultimediaClassroom,
            'need_marker_board' => $needMarkerBoard,
            'comment' => $comment,
            'hours_first_before' => $hoursFirstBefore,
            'hours_second_befor' => $hoursSecondBefor,
            'fours_first_after' => $foursFirstAfter,
            'hours_second_after' => $hoursSecondAfter
        ]);

        return ['status' => (boolean)$res];
    }

    public function setWorker(Request $request){
        $id = $request->get('load_element', null);
        $worker = $request->get('worker', null);

        if ($id === null || $worker === null)
            return ['status' => false];

        $issetDisElement = DB::table('distribution_element')->where('load_element_id', $id)->get()->first();
        if ($issetDisElement){
            $res = DB::table('distribution_element')->where('id', $issetDisElement->id)->update(['worker_id' => $worker]);
        }
        else{
            $res = DB::table('distribution_element')->insert(['load_element_id' => $id, 'worker_id' => $worker]);
        }
        return ['status' => (boolean)$res];
    }
}
