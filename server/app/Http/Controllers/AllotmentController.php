<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function getAllotment(Request $request){
        $id = $request->get('id', null);
        if (!$id)
            return ['status' => false];
        $allotment = DB::table('allotment')->where([['is_remove', '<>', true], ['id', $id]])->orderBy('id')->get()->first();
        if (!$allotment)
            return ['status' => false];
        $all_hours = DB::table('load_element')->where('allotment_id', $allotment->id)->sum('hours_planed');
        $dis_hours = DB::table('distribution_element')
            ->leftJoin('load_element', 'distribution_element.load_element_id','=', 'load_element.id')
            ->where('load_element.allotment_id', $allotment->id)->sum('load_element.hours_planed');

        $allotment->all_hours = $all_hours;
        $allotment->dis_hours = $dis_hours;

        return ['status' => true, 'data' => $allotment];
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

    public function parseFile(Request $request){
        $allotmentId = $request->get('allotment_id', null);
        $semester = $request->get('semester', null);
        $updateWorkers = $request->get('update_workers', 'false');
        $file = $request->file('file');

        $inputFileName = $file->getPathname();
        $spreadsheet = IOFactory::load($inputFileName);

        if ($updateWorkers === 'true'){
            $sheetData = $spreadsheet->getSheetByName('Осенний семестр');
            $this::updateWorkersFromSheet($sheetData);
        }

        if ($semester == 1 || $semester == 3) {
            $sheetData = $spreadsheet->getSheetByName('Осенний семестр');
            $this::parseSheet($allotmentId, 1, $sheetData);
        }
        if ($semester == 2 || $semester == 3) {
            $sheetData = $spreadsheet->getSheetByName('Весенний семестр');
            $this::parseSheet($allotmentId, 2, $sheetData);
        }

        return redirect()->route('page_hi_discipline', ['id' => $allotmentId]);
    }

    private function parseSheet($allotmentId, $semester, $sheetData){

        $row = 12; //13
        $disciplineCell = $sheetData->getCellByColumnAndRow(1,$row)->getFormattedValue();
        while ($disciplineCell){

            $groupCell = $sheetData->getCellByColumnAndRow(2,$row)->getFormattedValue();
            if (!$groupCell) {
                $row++;
                $disciplineCell = $sheetData->getCellByColumnAndRow(1,$row)->getFormattedValue();
                continue;
            }

            $disciplineCell = trim($disciplineCell);
            $disciplineCell = preg_replace('/ {2,}/',' ',$disciplineCell);
            $issetDiscipline = DB::table('discipline')->where('name', $disciplineCell)->get()->first();
            if ($issetDiscipline)
                $disciplineId = $issetDiscipline->id;
            else
                $disciplineId = DB::table('discipline')->insertGetId(['name' => $disciplineCell, 'full_name' => $disciplineCell]);

            //Распознавание группы

            $groupCell = trim($groupCell);
            $groupCell = preg_replace('/ {2,}/',' ',$groupCell);
            $arrGroup = explode(' ', $groupCell);
            foreach ($arrGroup as &$item){
                $item = trim($item);
            }
            $issetGroup = DB::table('group')->where('name', $arrGroup[1] . ' ' . $arrGroup[2])->get()->first();
            if ($issetGroup)
                $groupId = $issetGroup->id;
            else {
                $issetFaculty = DB::table('faculty')->where('name', $arrGroup[0])->get()->first();
                if ($issetFaculty)
                    $facultyId = $issetFaculty->id;
                else
                    $facultyId = DB::table('faculty')->insertGetId(['name' => $arrGroup[0], 'full_name' => $arrGroup[0]]);

                $arrModify = explode('-', $arrGroup[2]);

                $year = '20' . $arrModify[1];
                $qualifications = DB::table('qualification')->select('id', 'literal')->get()->all();
                $qualificationId = null;
                foreach ($qualifications as $qualification){
                    if (mb_strrpos($arrModify[2], $qualification->literal) !== false) {
                        $qualificationId = $qualification->id;
                        break;
                    }
                }

                $isFullTime = true;
                if (mb_strrpos($arrModify[2], 'з') !== false) {
                    $isFullTime = false;
                }
                $isAccelerated = false;
                if (mb_strrpos($arrModify[2], 'у') !== false) {
                    $isAccelerated = true;
                }

                $numberStudentsCell = $sheetData->getCellByColumnAndRow(3,$row)->getFormattedValue();
                $numberStudentsCell = trim($numberStudentsCell);
                $numberStudentsCell = preg_replace('/ {2,}/',' ',$numberStudentsCell);

                $issetSpecialty = DB::table('specialty')->where([['name', $arrGroup[1]], ['qualification_id', $qualificationId], ['faculty_id', $facultyId]])->get()->first();
                if ($issetSpecialty)
                    $specialtyId = $issetSpecialty->id;
                else
                    $specialtyId = DB::table('specialty')->insertGetId(['name' => $arrGroup[1], 'full_name' => $arrGroup[1], 'faculty_id' => $facultyId, 'qualification_id' => $qualificationId]);

                $groupId = DB::table('group')->insertGetId([
                    'name' => $arrGroup[1] . ' ' . $arrGroup[2],
                    'specialty_id' => $specialtyId,
                    'year_begin' => $year,
                    'is_full_time' => $isFullTime,
                    'is_accelerated' => $isAccelerated,
                    'number_students' => $numberStudentsCell ? $numberStudentsCell : null
                ]);
            }

            $subGroup = null;
            $subGroupCell = $sheetData->getCellByColumnAndRow(4,$row)->getFormattedValue();
            if ($subGroupCell) {
                $subGroupCell = trim($subGroupCell);
                $subGroupCell = preg_replace('/ {2,}/', ' ', $subGroupCell);
                $subGroup= $subGroupCell;
            }

            $typeClassCell = $sheetData->getCellByColumnAndRow(5,$row)->getFormattedValue();
            $typeClassCell = trim($typeClassCell);
            $typeClassCell = preg_replace('/ {2,}/',' ',$typeClassCell);
            $issetTypeClass = DB::table('type_class')->where('name', $typeClassCell)->get()->first();
            if ($issetTypeClass)
                $typeClassId = $issetTypeClass->id;
            else
                $typeClassId = DB::table('type_class')->insertGetId(['name' => $typeClassCell, 'full_name' => $typeClassCell]);

            $hoursPlanedCell = $sheetData->getCellByColumnAndRow(6,$row)->getFormattedValue();
            $hoursPlanedCell = trim($hoursPlanedCell);
            $hoursPlanedCell = preg_replace('/ {2,}/',' ',$hoursPlanedCell);

            $flowId = null;
            $flowCell = $sheetData->getCellByColumnAndRow(8,$row)->getFormattedValue();
            if ($flowCell) {
                $flowCell = trim($flowCell);
                $flowCell = preg_replace('/ {2,}/', ' ', $flowCell);
                $issetFlow = DB::table('flow')->where([['name', $typeClassCell], ['allotment_id', $allotmentId]])->get()->first();
                if ($issetFlow)
                    $flowId = $issetFlow->id;
                else
                    $flowId = DB::table('flow')->insertGetId(['name' => $flowCell, 'allotment_id' => $allotmentId]);
            }

            $buildingId = null;
            $classroomId = null;
            $buildingCell = $sheetData->getCellByColumnAndRow(9,$row)->getFormattedValue();
            if ($buildingCell) {
                $buildingCell = trim($buildingCell);
                $buildingCell = preg_replace('/ {2,}/', ' ', $buildingCell);
                $issetBuilding = DB::table('building')->where('name', $buildingCell)->get()->first();
                if ($issetBuilding)
                    $buildingId = $issetBuilding->id;
                else
                    $buildingId = DB::table('building')->insertGetId(['name' => $buildingCell, 'full_name' => $buildingCell]);

                $classroomCell = $sheetData->getCellByColumnAndRow(10,$row)->getFormattedValue();
                if ($classroomCell){
                    $classroomCell = trim($classroomCell);
                    $classroomCell = preg_replace('/ {2,}/', ' ', $classroomCell);
                    $issetClassroom = DB::table('classroom')->where([['name', $classroomCell], ['building_id', $buildingId]])->get()->first();
                    if ($issetClassroom)
                        $classroomId = $issetClassroom->id;
                    else
                        $classroomId = DB::table('classroom')->insertGetId(['name' => $classroomCell, 'building_id' => $buildingId]);
                }
            }

            $needInteractiveBoard = false;
            $needMultimediaClassroom = false;
            $needMarkerBoard = false;
            $classroomNeedleCell = $sheetData->getCellByColumnAndRow(11,$row)->getFormattedValue();
            if ($classroomNeedleCell){
                if (mb_strrpos($classroomNeedleCell, 'ИД') !== false) {
                    $needInteractiveBoard = true;
                }
                if (mb_strrpos($classroomNeedleCell, 'МА') !== false) {
                    $needMultimediaClassroom = true;
                }
                if (mb_strrpos($classroomNeedleCell, 'МД') !== false) {
                    $needMarkerBoard = true;
                }
            }

            $comment = null;
            $commentCell = $sheetData->getCellByColumnAndRow(12,$row)->getFormattedValue();
            if ($commentCell){
                $commentCell = trim($commentCell);
                $commentCell = preg_replace('/ {2,}/', ' ', $commentCell);
                $comment = $commentCell;
            }

            $hoursFirstBefore = null;
            $hoursFirstBeforeCell = $sheetData->getCellByColumnAndRow(13,$row)->getFormattedValue();
            if ($hoursFirstBeforeCell){
                $hoursFirstBeforeCell = trim($hoursFirstBeforeCell);
                $hoursFirstBeforeCell = preg_replace('/ {2,}/', ' ', $hoursFirstBeforeCell);
                $hoursFirstBefore = $hoursFirstBeforeCell;
            }
            $hoursSecondBefore = null;
            $hoursSecondBeforeCell = $sheetData->getCellByColumnAndRow(14,$row)->getFormattedValue();
            if ($hoursSecondBeforeCell){
                $hoursSecondBeforeCell = trim($hoursSecondBeforeCell);
                $hoursSecondBeforeCell = preg_replace('/ {2,}/', ' ', $hoursSecondBeforeCell);
                $hoursSecondBefore = $hoursSecondBeforeCell;
            }
            $hoursFirstAfter = null;
            $hoursFirstAfterCell = $sheetData->getCellByColumnAndRow(15,$row)->getFormattedValue();
            if ($hoursFirstAfterCell){
                $hoursFirstAfterCell = trim($hoursFirstAfterCell);
                $hoursFirstAfterCell = preg_replace('/ {2,}/', ' ', $hoursFirstAfterCell);
                $hoursFirstAfter = $hoursFirstAfterCell;
            }
            $hoursSecondAfter = null;
            $hoursSecondAfterCell = $sheetData->getCellByColumnAndRow(16,$row)->getFormattedValue();
            if ($hoursSecondAfterCell){
                $hoursSecondAfterCell = trim($hoursSecondAfterCell);
                $hoursSecondAfterCell = preg_replace('/ {2,}/', ' ', $hoursSecondAfterCell);
                $hoursSecondAfter = $hoursSecondAfterCell;
            }

            $loadElementId = DB::table('load_element')->insertGetId([
                'group_id' => $groupId,
                'classroom_id' => $classroomId,
                'discipline_id' => $disciplineId,
                'flow_id' => $flowId,
                'type_class_id' => $typeClassId,
                'allotment_id' => $allotmentId,
                'semester' => $semester,
                'sub_group' => $subGroup,
                'hours_planed' => $hoursPlanedCell,
                'need_interactive_board' => $needInteractiveBoard,
                'need_multimedia_classroom' => $needMultimediaClassroom,
                'need_marker_board' => $needMarkerBoard,
                'comment' => $comment,
                'hours_first_before' => $hoursFirstBefore,
                'hours_second_befor' => $hoursSecondBefore,
                'fours_first_after' => $hoursFirstAfter,
                'hours_second_after' => $hoursSecondAfter,
            ]);

            $i = 18;
            $cellWorker = $sheetData->getCellByColumnAndRow($i,1)->getFormattedValue();
            while (mb_strrpos($cellWorker, 'Вакансия') === false){
                $hoursDistributionCell = $sheetData->getCellByColumnAndRow($i,$row)->getFormattedValue();
                if ($hoursDistributionCell){
                    $cellWorker = trim($cellWorker);
                    $cellWorker = preg_replace('/ {2,}/', ' ', $cellWorker);
                    $hoursDistributionCell = trim($hoursDistributionCell);
                    $hoursDistributionCell = preg_replace('/ {2,}/', ' ', $hoursDistributionCell);

                    $arrFio = explode(' ', $cellWorker);

                    if (mb_strrpos($cellWorker, 'Ст.') !== false){
                        $fio = $arrFio[2] . ' ' . $arrFio[3] . (isset($arrFio[4]) ? ' ' . $arrFio[4] : '');
                    }
                    else{
                        $fio = $arrFio[1] . ' ' . $arrFio[2] . (isset($arrFio[3]) ? ' ' . $arrFio[3] : '');
                    }

                    $issetWorker = DB::table('worker')->where([['fio', $fio], ['not_active', '<>', true]])->get()->first();
                    if ($issetWorker){
                        DB::table('distribution_element')->insert(['load_element_id' => $loadElementId, 'worker_id' => $issetWorker->id]);
                    }
                }

                $i++;
                $cellWorker = $sheetData->getCellByColumnAndRow($i,1)->getFormattedValue();
            }

            $row++;
            $oldDisciplineCell = $disciplineCell;
            $disciplineCell = $sheetData->getCellByColumnAndRow(1,$row)->getFormattedValue();
            $groupCell = $sheetData->getCellByColumnAndRow(2,$row)->getFormattedValue();
            if (!$disciplineCell && $groupCell)
                $disciplineCell = $oldDisciplineCell;
        }

    }

    private function updateWorkersFromSheet($sheetData){
        $i = 18;
        //$cellValue = $sheetData->getCell('R1')->getFormattedValue();
        $cellValue = $sheetData->getCellByColumnAndRow($i,1)->getFormattedValue();
        while (mb_strrpos($cellValue, 'Вакансия') === false){

            $cellValue = trim($cellValue);
            $cellValue = preg_replace('/ {2,}/',' ',$cellValue);
            $arrFio = explode(' ', $cellValue);
            foreach ($arrFio as &$item){
                $item = trim($item);
            }
            if (mb_strrpos($cellValue, 'Ст.') !== false){
                $position = $arrFio[0] . ' ' . $arrFio[1];
                $surname = $arrFio[2];
                $name = $arrFio[3];
                $patronymic = null;
                if (isset($arrFio[4]))
                    $patronymic = $arrFio[4];
            }
            else{
                $position = $arrFio[0];
                $surname = $arrFio[1];
                $name = $arrFio[2];
                $patronymic = null;
                if (isset($arrFio[3]))
                    $patronymic = $arrFio[3];
            }
            $fio = $surname . ' ' . $name . ($patronymic ? ' ' . $patronymic : '');

            $issetWorker = DB::table('worker')->where('fio', $fio)->get()->first();
            if ($issetWorker)
                $workerId = $issetWorker->id;
            else
                $workerId = DB::table('worker')->insertGetId(['name' => $name, 'surname' => $surname, 'patronymic' => $patronymic, 'fio' => $fio]);

            $issetPosition = DB::table('position')->where('name', $position)->get()->first();
            if (!$issetPosition)
                $positionId = DB::table('position')->insertGetId(['name' => $position, 'full_name' => $position]);
            else
                $positionId = $issetPosition->id;

            $issetPositionWorker = DB::table('position_worker')->where('worker_id', $workerId)->orderBy('date_begin', 'desc')->get()->first();
            if ($issetPositionWorker){
                if ($issetPositionWorker->position_id != $positionId)
                    DB::table('position_worker')->insert(['worker_id' => $workerId, 'position_id' => $positionId, 'date_begin' => date('Y-m-d')]);
            }
            else
                DB::table('position_worker')->insert(['worker_id' => $workerId, 'position_id' => $positionId, 'date_begin' => date('Y-m-d')]);

            $issetRateWorker = DB::table('rate_worker')->where('worker_id', $workerId)->orderBy('date_begin', 'desc')->get()->first();
            if (!$issetRateWorker)
                DB::table('rate_worker')->insert(['worker_id' => $workerId, 'hours' => 800, 'date_begin' => date('Y-m-d')]);

            $issetDegreesWorker = DB::table('degrees_worker')->where('worker_id', $workerId)->orderBy('date_begin', 'desc')->get()->first();
            if (!$issetDegreesWorker)
                DB::table('degrees_worker')->insert(['worker_id' => $workerId, 'status' => false, 'date_begin' => date('Y-m-d')]);

            $issetStaffWorker = DB::table('staff_worker')->where('worker_id', $workerId)->orderBy('date_begin', 'desc')->get()->first();
            if (!$issetStaffWorker)
                DB::table('staff_worker')->insert(['worker_id' => $workerId, 'status' => false, 'date_begin' => date('Y-m-d')]);

            $issetTrainedWorker = DB::table('trained_worker')->where('worker_id', $workerId)->orderBy('date_begin', 'desc')->get()->first();
            if (!$issetTrainedWorker)
                DB::table('trained_worker')->insert(['worker_id' => $workerId, 'status' => false, 'date_begin' => date('Y-m-d')]);

            $i++;
            $cellValue = $sheetData->getCellByColumnAndRow($i,1)->getFormattedValue();
        }
    }
}
