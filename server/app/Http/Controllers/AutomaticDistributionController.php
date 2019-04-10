<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutomaticDistributionController extends Controller
{
    public function distribution(Request $request){
        $allotmentId = $request->get('allotment');
        $weightOld = $request->get('weight_old', 1);
        $weightWorker = $request->get('weight_worker', 1);
        $weightKaf = $request->get('weight_kaf', 1);

        $loadElements = DB::table('load_element')->where('allotment_id', $allotmentId)->get()->all();

        $workers = DB::table('worker')->where('not_active', '<>', true)->get()->all();
        foreach ($workers as &$worker){
            $hours = DB::table('rate_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->first();
            if (isset($hours))
                $worker->hours = $hours->hours;
            else
                $worker->hours = 600;
        }

        $F = [];
        $a1 = [];
        foreach ($loadElements as $loadElement){
            $group = DB::table('group')->where('id', $loadElement->group_id)->get()->first();
            if (!$group)
                continue;
            $a1[] = $loadElement->hours_planed;
            $first = false;
            foreach ($workers as $worker){
                if ($first)
                    $a1[] = 0;
                else
                    $first = true;

                $coefOldObj = DB::table('coefficients')->where([
                    ['type', 1],
                    ['worker_id', $worker->id],
                    ['discipline_id', $loadElement->discipline_id],
                    ['type_class_id', $loadElement->type_class_id],
                    ['speciality_id', $group->specialty_id],
                ])->get()->first();
                if (!$coefOldObj)
                    $coefOld = 0;
                else
                    $coefOld = $coefOldObj->coefficient;
                $coefWorkerObj = DB::table('coefficients')->where([
                    ['type', 2],
                    ['worker_id', $worker->id],
                    ['discipline_id', $loadElement->discipline_id],
                    ['type_class_id', $loadElement->type_class_id],
                    ['speciality_id', $group->specialty_id],
                ])->get()->first();
                if (!$coefWorkerObj)
                    $coefWorker = 0;
                else
                    $coefWorker = $coefWorkerObj->coefficient;
                $coefKafObj = DB::table('coefficients')->where([
                    ['type', 3],
                    ['worker_id', $worker->id],
                    ['discipline_id', $loadElement->discipline_id],
                    ['type_class_id', $loadElement->type_class_id],
                    ['speciality_id', $group->specialty_id],
                ])->get()->first();
                if (!$coefKafObj)
                    $coefKaf = 0;
                else
                    $coefKaf = $coefKafObj->coefficient;

                $F[] = ($loadElement->hours_planed * (($weightOld * $coefOld + $weightWorker * $coefWorker + $weightKaf * $coefKaf) / ($weightOld + $weightWorker + $weightKaf))) * -1;
            }
        }

        $A = [$a1];
        $b = [];
        foreach ($workers as $worker){
            $b[] = $worker->hours;
        }
        for ($i = 0; $i < count($workers); $i++){
            $A[] = array_unshift($A[$i], array_pop($A[$i]));
        }

        $Aeq = [];
        $beq = [];

        for ($i = 0; $i < count($loadElements); $i++) {
            foreach ($loadElements as $loadElement) {
                foreach ($workers as $worker) {
                    if ($loadElements[$i] == $loadElement) {
                        $Aeq[] = $loadElement->hours_planed;
                    } else {
                        $Aeq[] = 0;
                    }
                }
            }
            $beq[] = $loadElements[$i]->hours_planed;
        }

        if (strpos($_SERVER['SCRIPT_FILENAME'], '\\') === false) {
            $root = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/')) . '/';
        } else {
            $root = str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME']);
            $root = substr($root, 0, strrpos($root, '\\')) . '\\';
        }

        //$pythonPatch = 'C:\Users\geve9\AppData\Local\Programs\Python\Python37-32\python.exe'; //Для винды, изменять под себя!!!
        $networkPredictScript = 'E: && cd ' . $root . 'app/Extensions && ' . 'python' . ' vetv.py';
        $data = json_encode(['F' => $F, 'A' => $A, 'b' => $b, 'Aeq' => $Aeq, 'beq' => $beq]);
        $script = $networkPredictScript . ' "' . htmlspecialchars(trim($data)) . '"';
        exec($script, $out);


        return ['status' => true];
    }

    public function checkAllotment(Request $request){
        $allotmentId = $request->get('allotment');

        $elements = DB::table('distribution_element')
            ->leftJoin('load_element', 'distribution_element.load_element_id', '=', 'load_element.id')
            ->leftJoin('group', 'load_element.specialty_id', '=', 'group.id')
            ->where('load_element.allotment_id', $allotmentId)
            ->select('load_element.discipline_id AS discipline_id', 'load_element.type_class_id AS type_class_id', 'distribution_element.worker_id AS worker_id', 'group.specialty_id AS specialty_id')
            ->get()->all();

        $stepUp = env('AUTOMATIC_STEP', 0.2);

        foreach ($elements as $element){
            $coefficients = DB::table('coefficients')->where([
                ['discipline_id', $element->discipline_id],
                ['type_class_id', $element->type_class_id],
                ['speciality_id', $element->specialty_id]])
                ->get()->all();

            $stepDown = $stepUp / count($coefficients);

            $issetCoef = false;
            foreach ($coefficients as $coefficient){
                if ($coefficient->worker_id == $element->worker_id){
                    $coefValue = $coefficient->coefficient + $stepUp;
                    if ($coefValue > 1) $coefValue = 1;
                    $issetCoef = true;
                }
                else{
                    $coefValue = $coefficient->coefficient - $stepDown;
                    if ($coefValue < 0) $coefValue = 0;
                }
                DB::table('coefficients')->where('id', $coefficient->id)->update(['coefficient' => $coefValue]);
            }
            if (!$issetCoef){
                DB::table('coefficients')
                    ->insert([
                        'worker_id' => $element->worker_id,
                        'discipline_id' => $element->discipline_id,
                        'type_class_id' => $element->type_class_id,
                        'speciality_id' => $element->specialty_id,
                        'coefficient' => $stepUp
                ]);
            }
        }

        return ['status' => true];
    }
}
