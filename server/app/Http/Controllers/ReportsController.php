<?php

namespace App\Http\Controllers;

use App\Extensions\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function individualReport(Request $request){
        $allotmentId = $request->get('allotment', null);
        $workerId = $request->get('worker', null);
        $groupType = $request->get('group_type', 'full-time');

        $validator = Validator::make(['allotment_id' => $allotmentId, 'worker_id' => $workerId, 'group_type' => $groupType],[
           'allotment_id' => ['required', 'integer', Rule::exists('allotment','id')->where(function ($query){
               $query->where('is_remove', '<>', true);
           })],
            'worker_id' => ['required', 'integer', Rule::exists('worker','id')->where(function ($query){
                $query->where('not_active', '<>', true);
            })],
            'group_type' => ['required', Rule::in(['full-time', 'extramural'])]
        ]);
        if ($validator->fails())
            abort(404);

        $worker = DB::table('worker')->where('id', $workerId)->get()->first();

        $filterGroup = $groupType === 'full-time' ? ['group.is_full_time', true ] : ['group.is_full_time', '<>', true];
        $loads = DB::table('load_element')
            ->leftJoin('distribution_element', 'load_element.id', '=', 'distribution_element.load_element_id')
            ->leftJoin('worker', 'distribution_element.worker_id', '=', 'worker.id')
            ->leftJoin('discipline', 'load_element.discipline_id', '=', 'discipline.id')
            ->leftJoin('group', 'load_element.group_id', '=', 'group.id')
            ->leftJoin('type_class', 'load_element.type_class_id', '=', 'type_class.id')
            ->leftJoin('specialty', 'group.specialty_id', '=', 'specialty.id')
            ->leftJoin('faculty', 'specialty.faculty_id', '=', 'faculty.id')
            ->where([['load_element.allotment_id', $allotmentId], $filterGroup])
            ->select([
                'discipline.id AS discipline_id',
                'discipline.name AS discipline_name',
                'faculty.id AS faculty_id',
                'faculty.name AS faculty_name',
                'group.id AS group_id',
                'group.name AS group_name',
                'type_class.id AS type_class_id',
                'type_class.name AS type_class_name',
                'load_element.hours_planed AS hours',
                'load_element.semester AS semester',
                'worker.id AS worker_id',
                'worker.fio AS worker_fio'
            ])
            ->orderBy('discipline.id')
            ->orderBy('group.id')
            ->orderBy('type_class.id')
            ->get()->all();

        $autumnLoads = array_filter($loads, function ($item) {
            return $item->semester == 1;
        });
        $springLoads = array_filter($loads, function ($item) {
            return $item->semester == 2;
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Осенний семестр');
        $head = [
            [$worker->fio, 'Осенний семестр'],
            ['Наименование дисциплины', 'Факультет, группа', 'Вид занятия', 'Нагрузка', 'Ассистент/Преподаватель']
        ];
        $sheet->fromArray($head, null, 'A1');
        $sheet->getColumnDimension('A')->setWidth(63.57);
        $sheet->getColumnDimension('B')->setWidth(17.43);
        $sheet->getColumnDimension('C')->setWidth(16.29);
        $sheet->getColumnDimension('D')->setWidth(8.29);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getStyleByColumnAndRow(1, 1, 5, 2)->applyFromArray([
            'alignment'=>[
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' =>[
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ]
            ],
            'font'=>[
                'bold' => true,
                //'size' => 14
            ],
        ]);
        $sheet->getStyleByColumnAndRow(2,1,2,1)->applyFromArray([
            'font'=>[
                'bold' => false
            ],
        ]);

        $workerLoads = array_filter($autumnLoads, function ($item) use ($workerId) {
            return $item->worker_id == $workerId;
        });

        $hours = $this->writeIndividualLoads($sheet, $workerId, $workerLoads, $autumnLoads);

        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Весенний семестр');
        $head = [
            [$worker->fio, 'Осенний семестр'],
            ['Наименование дисциплины', 'Факультет, группа', 'Вид занятия', 'Нагрузка', 'Ассистент/Преподаватель']
        ];
        $sheet->fromArray($head, null, 'A1');
        $sheet->getColumnDimension('A')->setWidth(63.57);
        $sheet->getColumnDimension('B')->setWidth(17.43);
        $sheet->getColumnDimension('C')->setWidth(16.29);
        $sheet->getColumnDimension('D')->setWidth(8.29);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getStyleByColumnAndRow(1, 1, 5, 2)->applyFromArray([
            'alignment'=>[
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' =>[
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ]
            ],
            'font'=>[
                'bold' => true,
                //'size' => 14
            ],
        ]);
        $sheet->getStyleByColumnAndRow(2,1,2,1)->applyFromArray([
            'font'=>[
                'bold' => false
            ],
        ]);

        $workerLoads = array_filter($springLoads, function ($item) use ($workerId) {
            return $item->worker_id == $workerId;
        });
        $hours = $this->writeIndividualLoads($sheet, $workerId, $workerLoads, $springLoads, $hours);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = Helpers::getRoot() . 'public/' . md5(microtime() . rand(100000, 999999));

        $writer->save($fileName);
        return response()->download($fileName, 'Индивидуальная нагрузка преподавателя' . $worker->fio . '.xlsx')->deleteFileAfterSend(true);
    }

    private function writeIndividualLoads($sheet, $workerId, $workerLoads, $loads, $hoursAll = null){
        $hours = 0;
        $i = 3;
        $firstGroupCell = $i;
        $group = null;
        $faculty = null;
        $firstDisciplineCell = $i;
        $discipline = null;
        foreach ($workerLoads as $workerLoad) {
            if ($discipline == null){
                $discipline = $workerLoad->discipline_name;
            }
            if ($group == null){
                $faculty = $workerLoad->faculty_name;
                $group = $workerLoad->group_name;
            }
            if ($workerLoad->group_name != $group || $workerLoad->discipline_name != $discipline){

                $anotherLoads = array_filter($loads, function ($item) use ($workerId, $group, $discipline) {
                    return $item->worker_id != $workerId && $item->discipline_name == $discipline && $item->group_name == $group;
                });

                foreach ($anotherLoads as $anotherLoad){
                    $sheet->setCellValueByColumnAndRow(3, $i, $anotherLoad->type_class_name);
                    $sheet->setCellValueByColumnAndRow(4, $i, $anotherLoad->hours);
                    $sheet->setCellValueByColumnAndRow(5, $i, $anotherLoad->worker_fio ? $anotherLoad->worker_fio : 'Не назначен');
                    $i++;
                }

                $sheet->mergeCellsByColumnAndRow(2, $firstGroupCell, 2, $i - 1);
                $sheet->setCellValueByColumnAndRow(2, $firstGroupCell, $faculty . ' ' . $group);

                $firstGroupCell = $i;
                $faculty = $workerLoad->faculty_name;
                $group = $workerLoad->group_name;
            }
            if ($workerLoad->discipline_name != $discipline){
                $sheet->mergeCellsByColumnAndRow(1, $firstDisciplineCell, 1, $i - 1);
                $sheet->setCellValueByColumnAndRow(1, $firstDisciplineCell, $discipline);
                $firstDisciplineCell = $i;
                $discipline = $workerLoad->discipline_name;
            }

            $sheet->setCellValueByColumnAndRow(3, $i, $workerLoad->type_class_name);
            $sheet->setCellValueByColumnAndRow(4, $i, $workerLoad->hours);
            $hours += $workerLoad->hours;

            $i++;
        }

        $anotherLoads = array_filter($loads, function ($item) use ($workerId, $group, $discipline) {
            return $item->worker_id != $workerId && $item->discipline_name == $discipline && $item->group_name == $group;
        });

        foreach ($anotherLoads as $anotherLoad){
            $sheet->setCellValueByColumnAndRow(3, $i, $anotherLoad->type_class_name);
            $sheet->setCellValueByColumnAndRow(4, $i, $anotherLoad->hours);
            $sheet->setCellValueByColumnAndRow(5, $i, $anotherLoad->worker_fio ? $anotherLoad->worker_fio : 'Не назначен');
            $i++;
        }

        $sheet->mergeCellsByColumnAndRow(2, $firstGroupCell, 2, $i - 1);
        $sheet->setCellValueByColumnAndRow(2, $firstGroupCell, $faculty . ' ' . $group);

        $sheet->mergeCellsByColumnAndRow(1, $firstDisciplineCell, 1, $i - 1);
        $sheet->setCellValueByColumnAndRow(1, $firstDisciplineCell, $discipline);

        $sheet->setCellValueByColumnAndRow(3, $i, 'Всего за семестр:');
        $sheet->setCellValueByColumnAndRow(4, $i, $hours);
        $sheet->getStyleByColumnAndRow(3,$i,4,$i)->applyFromArray([
            'font'=>[
                'bold' => true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFF03D',
                ],
            ]
        ]);
        if (isset($hoursAll)){
            $i++;
            $sheet->setCellValueByColumnAndRow(3, $i, 'Всего за год:');
            $sheet->setCellValueByColumnAndRow(4, $i, $hoursAll + $hours);
            $sheet->getStyleByColumnAndRow(3,$i,4,$i)->applyFromArray([
                'font'=>[
                    'bold' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFF03D',
                    ],
                ]
            ]);
        }

        $sheet->getStyleByColumnAndRow(1, 3, 5, $i)->applyFromArray([
            'alignment'=>[
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' =>[
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ]
            ]
        ]);


        return $hours;
    }
}
