<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function getDepartmentReport(Request $request){
        $allotment = $request->get('allotment', null);

        $allotment = DB::table('allotment')->where('id', $allotment)->get()->first();
        if (!isset($allotment))
            abort(404);

        $workers = DB::table('worker')->where('not_active', '<>', true)->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $position = DB::table('position_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->first();
            $worker->position = $position;
            $rate = DB::table('rate_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->first();
            if ($rate)
                $worker->rate = $rate;
            else
                $worker->rate = 800;
        }
        $typesClass = DB::table('type_class')->get()->all();
        $needTypes = [
            ['bdName' => 'Лек', 'name' => 'лекции'],
            ['bdName' => 'Пр', 'name' => 'практич. занятия'],
            ['bdName' => 'КСР', 'name' => 'КСР'],
            ['bdName' => 'Лаб', 'name' => 'лаборат. занятия'],
            ['bdName' => 'Экз', 'name' => 'экзамены'],
            ['bdName' => 'Зач', 'name' => 'зачеты'],
            ['bdName' => 'ДифЗач', 'name' => 'зачеты'],
            ['bdName' => 'КП', 'name' => 'курсовое проект.'],
            ['bdName' => 'УчПр', 'name' => 'Практика'],
            ['bdName' => 'ПрПр', 'name' => 'Практика'],
            ['bdName' => 'РукВКР', 'name' => 'ВКР'],
            ['bdName' => 'ГЭК', 'name' => 'ГЭК'],
            ['bdName' => 'Рец', 'name' => 'рецензирование ВКР'],
            ['bdName' => 'КР', 'name' => 'проверка контр. работ'],
        ];

        $loads = DB::table('distribution_element')
            ->select(DB::raw('SUM(load_element.hours_planed) AS hours, load_element.type_class_id, distribution_element.worker_id'))
            ->leftJoin('load_element', 'distribution_element.load_element_id', '=', 'load_element.id')
            ->where('load_element.allotment_id', $allotment->id)
            ->groupBy('distribution_element.worker_id', 'load_element.type_class_id')
            ->get()->all();



        foreach ($workers as $worker){

        }
    }
}
