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
        $elementsIds = [];
        foreach ($loadElements as $loadElement){
            $elementsIds[] = $loadElement->id;
            $group = DB::table('group')->where('id', $loadElement->group_id)->get()->first();
            if (!$group)
                continue;
            $a1[] = (float)$loadElement->hours_planed;
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

                $F[] = (float)($loadElement->hours_planed * (($weightOld * $coefOld + $weightWorker * $coefWorker + $weightKaf * $coefKaf) / ($weightOld + $weightWorker + $weightKaf))) * -1;
            }
        }

        $A = [$a1];
        $b = [];
        foreach ($workers as $worker){
            $b[] = (float)$worker->hours;
        }
        for ($i = 0; $i < count($workers); $i++){
            $newAi = $A[$i];
            array_unshift($newAi, array_pop($newAi));//TODO
            $A[] = $newAi;
        }

        $Aeq = [];
        $beq = [];

        for ($i = 0; $i < count($loadElements); $i++) {
            $AeqLine = [];
            foreach ($loadElements as $loadElement) {
                foreach ($workers as $worker) {
                    if ($loadElements[$i] == $loadElement) {
                        $AeqLine[] = (float)$loadElement->hours_planed;
                    } else {
                        $AeqLine[] = 0;
                    }
                }
            }
            $Aeq[] = $AeqLine;
            $beq[] = (float)$loadElements[$i]->hours_planed;
        }

        $root = str_replace('public', '', $_SERVER['DOCUMENT_ROOT']);

        //$pythonPatch = 'C:\Users\geve9\AppData\Local\Programs\Python\Python37-32\python.exe'; //Для винды, изменять под себя!!!
        $networkPredictScript = 'E: && cd ' . $root . 'app/Extensions && ' . 'python' . ' vetv.py';
        $data = json_encode(['F' => $F, 'A' => $A, 'b' => $b, 'Aeq' => $Aeq, 'beq' => $beq]);
        file_put_contents($root . 'app/Extensions/data.txt', $data);
        //$script = $networkPredictScript . ' "' . htmlspecialchars(trim($data)) . '"';
        exec($networkPredictScript, $out);
        if (count($out) > 0){
            $autoAllotment = json_decode(end($out), true);
            if (gettype($autoAllotment) === 'array'){
                DB::table('distribution_element')->whereIn('load_element_id', $elementsIds)->delete();
                $i = 0;
                foreach ($loadElements as $loadElement){
                    foreach ($workers as $worker){
                        if ($autoAllotment[$i] == 1){
                            DB::table('distribution_element')->insert(['load_element_id' => $loadElement->id, 'worker_id' => $worker->id]);
                        }
                        $i++;
                    }
                }
            }
            else
                return ['status' => false];
        }
        else
            return ['status' => false];

        return ['status' => true];
    }

    public function checkAllotment(Request $request){
        $allotmentId = $request->get('allotment');

        $elements = DB::table('distribution_element')
            ->leftJoin('load_element', 'distribution_element.load_element_id', '=', 'load_element.id')
            ->leftJoin('group', 'load_element.group_id', '=', 'group.id')
            ->where('load_element.allotment_id', $allotmentId)
            ->select('load_element.discipline_id AS discipline_id', 'load_element.type_class_id AS type_class_id', 'distribution_element.worker_id AS worker_id', 'group.specialty_id AS specialty_id')
            ->get()->all();

        $stepUp = env('AUTOMATIC_STEP', 0.2);

        foreach ($elements as $element){
            $coefficients = DB::table('coefficients')->where([
                ['discipline_id', $element->discipline_id],
                ['type_class_id', $element->type_class_id],
                ['speciality_id', $element->specialty_id]],
                ['type', 1])
                ->get()->all();

            $stepDown = $stepUp / (count($coefficients) + 1);

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
                        'coefficient' => $stepUp,
                        'type' => 1
                ]);
            }
        }

        return ['status' => true];
    }
}
