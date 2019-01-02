<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HiDisciplineController extends Controller
{

    public function getDisciplines(Request $request){
        $allotment = $request->get('allotment', null);
        $semester = $request->get('semester', null);
        if (!$allotment || !$semester)
            return ['status' => false];

        $disciplinesQuery = DB::table('load_element')
            ->where('allotment_id', $allotment)
            ->leftJoin('discipline', 'load_element.discipline_id', '=', 'discipline.id')
            ->select('discipline.name AS name', 'discipline.id AS id', 'discipline.full_name AS full_name')
            ->orderBy('discipline.name');

        if ($semester != 3)
            $disciplinesQuery->where('semester', $semester);

        $disciplines = $disciplinesQuery->distinct()->get()->all();

        foreach ($disciplines as &$discipline){
            $all_hours_query = DB::table('load_element')
                ->where([['allotment_id', $allotment], ['discipline_id', $discipline->id]]);

            if ($semester != 3)
                $all_hours_query->where('semester', $semester);

            $all_hours = $all_hours_query->sum('hours_planed');
            $dis_hours_query = DB::table('distribution_element')
                ->leftJoin('load_element', 'distribution_element.load_element_id','=', 'load_element.id')
                ->where([['load_element.allotment_id', $allotment], ['load_element.discipline_id', $discipline->id]]);

            if ($semester != 3)
                $dis_hours_query->where('load_element.semester', $semester);

            $dis_hours = $dis_hours_query->sum('load_element.hours_planed');

            $discipline->all_hours = $all_hours;
            $discipline->dis_hours = $dis_hours;
        }

        return ['status' => true, 'data' => $disciplines];
    }

    public function getGroups(Request $request){
        $allotment = $request->get('allotment', null);
        $semester = $request->get('semester', null);
        $discipline = $request->get('discipline', null);
        if (!$allotment || !$semester || !$discipline)
            return ['status' => false];

        $groupsQuery = DB::table('load_element')
            ->where([['allotment_id', $allotment], ['discipline_id', $discipline]])
            ->leftJoin('group', 'load_element.group_id', '=', 'group.id')
            ->select('group.name AS name', 'group.id AS id')
            ->orderBy('group.name');

        if ($semester != 3)
            $groupsQuery->where('semester', $semester);

        $groups = $groupsQuery->distinct()->get()->all();

        foreach ($groups as &$group){
            $all_hours_query = DB::table('load_element')
                ->where([['allotment_id', $allotment], ['discipline_id', $discipline], ['group_id', $group->id]]);

            if ($semester != 3)
                $all_hours_query->where('semester', $semester);

            $all_hours = $all_hours_query->sum('hours_planed');
            $dis_hours_query = DB::table('distribution_element')
                ->leftJoin('load_element', 'distribution_element.load_element_id','=', 'load_element.id')
                ->where([['load_element.allotment_id', $allotment], ['load_element.discipline_id', $discipline], ['load_element.group_id', $group->id]]);

            if ($semester != 3)
                $dis_hours_query->where('load_element.semester', $semester);

            $dis_hours = $dis_hours_query->sum('load_element.hours_planed');

            $group->all_hours = $all_hours;
            $group->dis_hours = $dis_hours;
        }

        $distributionElementsQuery = DB::table('distribution_element')
            ->leftJoin('load_element', 'distribution_element.load_element_id', '=', 'load_element.id')
            ->leftJoin('worker', 'distribution_element.worker_id', '=', 'worker.id')
            ->leftJoin('group', 'load_element.group_id', '=', 'group.id')
            ->leftJoin('type_class', 'load_element.type_class_id', '=', 'type_class.id')
            ->where([['load_element.allotment_id', $allotment], ['load_element.discipline_id', $discipline]])
            ->select('worker.fio AS fio', 'worker.id AS id', 'group.name AS group', 'type_class.name AS type_class')
            ->orderBy('worker.fio');

        if ($semester != 3)
            $distributionElementsQuery->where('load_element.semester', $semester);

        $distributionElements = $distributionElementsQuery->distinct()->get()->all();
        return ['status' => true, 'data' => ['groups' => $groups, 'distributionElements' => $distributionElements]];
    }

    public function getLoadElements(Request $request){
        $allotment = $request->get('allotment', null);
        $semester = $request->get('semester', null);
        $discipline = $request->get('discipline', null);
        $group = $request->get('group', null);
        if (!$allotment || !$semester || !$discipline || !$group)
            return ['status' => false];

        $loadElementsQuery = DB::table('load_element')
            ->where([['allotment_id', $allotment], ['discipline_id', $discipline], ['group_id', $group]])
            ->leftJoin('type_class', 'load_element.type_class_id', '=', 'type_class.id')
            ->select('type_class.name AS name', 'load_element.id AS id', 'type_class.full_name AS full_name', 'load_element.sub_group AS sub_group', 'load_element.hours_planed AS all_hours')
            ->orderBy('type_class.name');

        if ($semester != 3)
            $loadElementsQuery->where('semester', $semester);

        $loadElements = $loadElementsQuery->distinct()->get()->all();

        foreach ($loadElements as &$loadElement){

            $worker = DB::table('distribution_element')
                ->leftJoin('worker', 'distribution_element.worker_id', '=', 'worker.id')
                ->select('worker_id AS id', 'worker.fio AS fio')
                ->where('load_element_id', $loadElement->id)->get()->first();
            if ($worker) {
                $loadElement->dis_hours = $loadElement->all_hours;
                $loadElement->worker_fio = $worker->fio;
                $loadElement->worker_id = $worker->id;
            }
            else{
                $loadElement->dis_hours = 0;
                $loadElement->worker_fio = null;
                $loadElement->worker_id = null;
            }
        }

        return ['status' => true, 'data' => $loadElements];
    }

    public function getLoadElement(Request $request){
        $loadElement = $request->get('load_element', null);
        if (!$loadElement)
            return ['status' => false];

        $dbLoadElement = DB::table('load_element')->where('id', $loadElement)->get()->first();

        $name = DB::table('type_class')->select('full_name')->where('id', $dbLoadElement->type_class_id)->get()->first();
        $dbLoadElement->name = $name->full_name;

        $worker = DB::table('distribution_element')
            ->leftJoin('worker', 'distribution_element.worker_id', '=', 'worker.id')
            ->select('worker_id AS id', 'worker.fio AS fio')
            ->where('load_element_id', $loadElement)->get()->first();
        $dbLoadElement->all_hours = $dbLoadElement->hours_planed;
        if ($worker) {
            $dbLoadElement->dis_hours = $dbLoadElement->all_hours;
            $dbLoadElement->worker_fio = $worker->fio;
            $dbLoadElement->worker_id = $worker->id;
        }
        else{
            $dbLoadElement->dis_hours = 0;
            $dbLoadElement->worker_fio = null;
            $dbLoadElement->worker_id = null;
        }
        return ['status' => true, 'data' => $dbLoadElement];
    }

    public function setWorkerGroup(Request $request){
        $group = $request->get('group', null);
        $allotment = $request->get('allotment', null);
        $discipline = $request->get('discipline', null);
        $worker = $request->get('worker', null);

        if ($group === null || $discipline === null || $allotment === null || $worker === null)
            return ['status' => false];

        $loadElements = DB::table('load_element')->select('id')->where([['discipline_id', $discipline], ['group_id', $group], ['allotment_id', $allotment]])->get()->all();

        foreach ($loadElements as $loadElement){
            $issetDisElement = DB::table('distribution_element')->where('load_element_id', $loadElement->id)->get()->first();
            if ($issetDisElement){
                DB::table('distribution_element')->where('id', $issetDisElement->id)->update(['worker_id' => $worker]);
            }
            else{
                DB::table('distribution_element')->insert(['load_element_id' => $loadElement->id, 'worker_id' => $worker]);
            }
        }

        return ['status' => true];
    }

    public function setWorkerDiscipline(Request $request){
        $allotment = $request->get('allotment', null);
        $discipline = $request->get('discipline', null);
        $worker = $request->get('worker', null);

        if ($discipline === null || $allotment === null || $worker === null)
            return ['status' => false];

        $loadElements = DB::table('load_element')->select('id')->where([['discipline_id', $discipline], ['allotment_id', $allotment]])->get()->all();

        foreach ($loadElements as $loadElement){
            $issetDisElement = DB::table('distribution_element')->where('load_element_id', $loadElement->id)->get()->first();
            if ($issetDisElement){
                DB::table('distribution_element')->where('id', $issetDisElement->id)->update(['worker_id' => $worker]);
            }
            else{
                DB::table('distribution_element')->insert(['load_element_id' => $loadElement->id, 'worker_id' => $worker]);
            }
        }

        return ['status' => true];
    }

}
