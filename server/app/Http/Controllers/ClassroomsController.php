<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomsController extends Controller
{
    public function getClassrooms(Request $request){
        $classroomsDB = DB::table('classroom')
            ->leftJoin('building', 'classroom.building_id', '=', 'building.id')
            ->select('classroom.id AS id', 'classroom.name AS classroom', 'building.name AS building')
            ->orderBy('building.name')
            ->orderBy('classroom.name')->get()->all();

        $classrooms = [];
        foreach ($classroomsDB as $classroom){
            $classrooms[] = ['id' => $classroom->id, 'name' => 'Аудитория ' . $classroom->classroom . ', ' . $classroom->building];
        }
        return ['status' => true, 'data' => $classrooms];
    }
}
