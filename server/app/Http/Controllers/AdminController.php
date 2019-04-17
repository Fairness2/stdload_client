<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function getRoles(Request $request){
        $roles = DB::table('roles')->orderBy('public_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createRole(Request $request){
        $name = $request->get('name', null);
        $publicName = $request->get('public_name', null);
        if ($name === null || $publicName === null)
            return ['status' => false];

        $res = DB::table('roles')->insert(['name' => $name, 'public_name' => $publicName]);
        return ['status' => (boolean)$res];
    }

    public function editRole(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $publicName = $request->get('public_name', null);
        if ($name === null || $id === null || $publicName === null)
            return ['status' => false];

        $res = DB::table('roles')->where('id', $id)->update(['name' => $name, 'public_name' => $publicName]);
        return ['status' => (boolean)$res];
    }

    public function removeRole(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('roles')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getTypeClass(Request $request){
        $roles = DB::table('type_class')->orderBy('full_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createTypeClass(Request $request){
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('type_class')->insert(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function editTypeClass(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $id === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('type_class')->where('id', $id)->update(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function removeTypeClass(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('type_class')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getQualification(Request $request){
        $roles = DB::table('qualification')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createQualification(Request $request){
        $name = $request->get('name', null);
        $literal = $request->get('literal', null);
        if ($name === null || $literal === null)
            return ['status' => false];

        $res = DB::table('qualification')->insert(['name' => $name, 'literal' => $literal]);
        return ['status' => (boolean)$res];
    }

    public function editQualification(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $literal = $request->get('literal', null);
        if ($name === null || $id === null || $literal === null)
            return ['status' => false];

        $res = DB::table('qualification')->where('id', $id)->update(['name' => $name, 'literal' => $literal]);
        return ['status' => (boolean)$res];
    }

    public function removeQualification(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('qualification')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getPosition(Request $request){
        $roles = DB::table('position')->orderBy('full_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createPosition(Request $request){
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('position')->insert(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function editPosition(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $id === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('position')->where('id', $id)->update(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function removePosition(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('position')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getFaculty(Request $request){
        $roles = DB::table('faculty')->orderBy('full_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createFaculty(Request $request){
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('faculty')->insert(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function editFaculty(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $id === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('faculty')->where('id', $id)->update(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function removeFaculty(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('faculty')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getDiscipline(Request $request){
        $roles = DB::table('discipline')->orderBy('full_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createDiscipline(Request $request){
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('discipline')->insert(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function editDiscipline(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        if ($name === null || $id === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('discipline')->where('id', $id)->update(['name' => $name, 'full_name' => $fullName]);
        return ['status' => (boolean)$res];
    }

    public function removeDiscipline(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('discipline')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getBuilding(Request $request){
        $roles = DB::table('building')->orderBy('full_name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createBuilding(Request $request){
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        $address = $request->get('address', null);
        if ($name === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('building')->insert(['name' => $name, 'full_name' => $fullName, 'address' => $address]);
        return ['status' => (boolean)$res];
    }

    public function editBuilding(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $fullName = $request->get('full_name', null);
        $address = $request->get('address', null);
        if ($name === null || $id === null || $fullName === null)
            return ['status' => false];

        $res = DB::table('building')->where('id', $id)->update(['name' => $name, 'full_name' => $fullName, 'address' => $address]);
        return ['status' => (boolean)$res];
    }

    public function removeBuilding(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('building')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getClassroom(Request $request){
        $roles = DB::table('classroom')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createClassroom(Request $request){
        $name = $request->get('name', null);
        $buildingId = $request->get('building_id', null);
        if ($name === null || $buildingId === null)
            return ['status' => false];

        $res = DB::table('classroom')->insert(['name' => $name, 'building_id' => $buildingId]);
        return ['status' => (boolean)$res];
    }

    public function editClassroom(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $buildingId = $request->get('building_id', null);
        if ($name === null || $id === null || $buildingId === null)
            return ['status' => false];

        $res = DB::table('classroom')->where('id', $id)->update(['name' => $name, 'building_id' => $buildingId]);
        return ['status' => (boolean)$res];
    }

    public function removeClassroom(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('classroom')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getSpecialty(Request $request){
        $roles = DB::table('specialty')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createSpecialty(Request $request){
        $name = $request->get('name', null);
        $facultyId = $request->get('faculty_id', null);
        $fullName = $request->get('full_name', null);
        $qualificationId = $request->get('qualification_id', null);
        if ($name === null || $facultyId === null || $fullName === null || $qualificationId === null)
            return ['status' => false];

        $res = DB::table('specialty')->insert(['name' => $name, 'faculty_id' => $facultyId, 'full_name' => $fullName, 'qualification_id' => $qualificationId]);
        return ['status' => (boolean)$res];
    }

    public function editSpecialty(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $facultyId = $request->get('faculty_id', null);
        $fullName = $request->get('full_name', null);
        $qualificationId = $request->get('qualification_id', null);
        if ($name === null || $id === null || $facultyId === null || $fullName === null || $qualificationId === null)
            return ['status' => false];

        $res = DB::table('specialty')->where('id', $id)->update(['name' => $name, 'faculty_id' => $facultyId, 'full_name' => $fullName, 'qualification_id' => $qualificationId]);
        return ['status' => (boolean)$res];
    }

    public function removeSpecialty(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('specialty')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getRequirementFgos(Request $request){
        $roles = DB::table('requirement_fgos')->orderBy('year_begin')->orderBy('year_end')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createRequirementFgos(Request $request){
        $specialtyId = $request->get('specialty_id', null);
        $outWorkers = $request->get('out_workers', null);
        $degrees = $request->get('degrees', null);
        $innerWorkers = $request->get('inner_workers', null);
        $trainedWorker = $request->get('trained_worker', null);
        $yearBegin = $request->get('year_begin', null);
        $yearEnd = $request->get('year_end', null);
        if ($specialtyId === null || $outWorkers === null || $degrees === null || $innerWorkers === null || $trainedWorker === null || $yearBegin === null || $yearEnd === null)
            return ['status' => false];

        $res = DB::table('requirement_fgos')->insert(['specialty_id' => $specialtyId, 'out_workers' => $outWorkers, 'degrees' => $degrees, 'inner_workers' => $innerWorkers,
            'trained_worker' => $trainedWorker, 'year_begin' => $yearBegin, 'year_end' => $yearEnd]);
        return ['status' => (boolean)$res];
    }

    public function editRequirementFgos(Request $request){
        $id = $request->get('id', null);
        $specialtyId = $request->get('specialty_id', null);
        $outWorkers = $request->get('out_workers', null);
        $degrees = $request->get('degrees', null);
        $innerWorkers = $request->get('inner_workers', null);
        $trainedWorker = $request->get('trained_worker', null);
        $yearBegin = $request->get('year_begin', null);
        $yearEnd = $request->get('year_end', null);
        if ($specialtyId === null || $id === null || $outWorkers === null || $degrees === null || $innerWorkers === null || $trainedWorker === null || $yearBegin === null || $yearEnd === null)
            return ['status' => false];

        $res = DB::table('requirement_fgos')->where('id', $id)->update(['specialty_id' => $specialtyId, 'out_workers' => $outWorkers, 'degrees' => $degrees, 'inner_workers' => $innerWorkers,
            'trained_worker' => $trainedWorker, 'year_begin' => $yearBegin, 'year_end' => $yearEnd]);
        return ['status' => (boolean)$res];
    }

    public function removeRequirementFgos(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('requirement_fgos')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getGroup(Request $request){
        $roles = DB::table('group')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createGroup(Request $request){
        $specialtyId = $request->get('specialty_id', null);
        $name = $request->get('name', null);
        $yearBegin = $request->get('year_begin', null);
        $isFullTime = $request->get('is_full_time', true);
        $isAccelerated = $request->get('is_accelerated', false);
        $numberStudents = $request->get('number_students', null);
        if ($specialtyId === null || $name === null || $yearBegin === null)
            return ['status' => false];

        $res = DB::table('group')->insert(['specialty_id' => $specialtyId, 'name' => $name, 'year_begin' => $yearBegin, 'is_full_time' => $isFullTime,
            'is_accelerated' => $isAccelerated, 'number_students' => $numberStudents]);
        return ['status' => (boolean)$res];
    }

    public function editGroup(Request $request){
        $id = $request->get('id', null);
        $specialtyId = $request->get('specialty_id', null);
        $name = $request->get('name', null);
        $yearBegin = $request->get('year_begin', null);
        $isFullTime = $request->get('is_full_time', true);
        $isAccelerated = $request->get('is_accelerated', false);
        $numberStudents = $request->get('number_students', null);
        if ($specialtyId === null || $id === null || $name === null || $yearBegin === null)
            return ['status' => false];

        $res = DB::table('group')->where('id', $id)->update(['specialty_id' => $specialtyId, 'name' => $name, 'year_begin' => $yearBegin, 'is_full_time' => $isFullTime,
            'is_accelerated' => $isAccelerated, 'number_students' => $numberStudents]);
        return ['status' => (boolean)$res];
    }

    public function removeGroup(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('group')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getFlow(Request $request){
        $roles = DB::table('flow')->orderBy('name')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createFlow(Request $request){
        $name = $request->get('name', null);
        $allotmentId = $request->get('allotment_id', null);
        if ($allotmentId === null || $name === null)
            return ['status' => false];

        $res = DB::table('flow')->insert(['name' => $name, 'allotment_id' => $allotmentId]);
        return ['status' => (boolean)$res];
    }

    public function editFlow(Request $request){
        $id = $request->get('id', null);
        $name = $request->get('name', null);
        $allotmentId = $request->get('allotment_id', null);
        if ($name === null || $id === null || $allotmentId === null)
            return ['status' => false];

        $res = DB::table('flow')->where('id', $id)->update(['name' => $name, 'allotment_id' => $allotmentId]);
        return ['status' => (boolean)$res];
    }

    public function removeFlow(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('flow')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getUser(Request $request){
        $users = DB::table('users')->select('id' ,'email', 'name', 'worker_id')->orderBy('email')->get()->all();

        foreach ($users as &$user){
            $roles = DB::table('ref_user_roles')->where('user_id', $user->id)->get()->all();
            $user->roles = [];
            foreach ($roles as $role){
                $user->roles[] = $role->role_id;
            }
        }

        return ['status' => true, 'data' => $users];
    }

    public function editUser(Request $request){
        $id = $request->get('id', null);
        $workerId = $request->get('worker_id', null);
        $roles = $request->get('roles', null);
        if ($id === null)
            return ['status' => false];

        DB::table('users')->where('id', $id)->update(['worker_id' => $workerId]);

        DB::table('ref_user_roles')->where('user_id', $id)->delete();
        foreach ($roles as $role){
            DB::table('ref_user_roles')->insert(['user_id' => $id, 'role_id' => $role]);
        }
        return ['status' => true];
    }

    public function getWorker(Request $request){
        $roles = DB::table('worker')->orderBy('fio')->get()->all();
        return ['status' => true, 'data' => $roles];
    }

    public function createWorker(Request $request){
        $fio = $request->get('fio', null);
        $surname = $request->get('surname', null);
        $name = $request->get('name', null);
        $patronymic = $request->get('patronymic', null);
        if ($fio === null || $name === null || $surname === null)
            return ['status' => false];

        $res = DB::table('worker')->insert(['name' => $name, 'surname' => $surname, 'patronymic' => $patronymic, 'fio' => $fio]);
        return ['status' => (boolean)$res];
    }

    public function editWorker(Request $request){
        $id = $request->get('id', null);
        $fio = $request->get('fio', null);
        $surname = $request->get('surname', null);
        $name = $request->get('name', null);
        $patronymic = $request->get('patronymic', null);
        $notActive = $request->get('not_active', false);
        if ($id === null || $fio === null || $name === null || $surname === null)
            return ['status' => false];

        $res = DB::table('worker')->where('id', $id)->update(['name' => $name, 'surname' => $surname, 'patronymic' => $patronymic, 'fio' => $fio, 'not_active' => $notActive]);
        return ['status' => (boolean)$res];
    }

    public function removeWorker(Request $request){
        $id = $request->get('id', null);
        if ($id === null)
            return ['status' => false];

        $res = DB::table('worker')->where('id', $id)->delete();
        return ['status' => (boolean)$res];
    }

    public function getDegreesWorker(Request $request){
        $workers = DB::table('worker')->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $history = DB::table('degrees_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->all();
            //$status = DB::table('degrees_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->first();
            if (count($history) > 0)
                $worker->status = $history[0]->status;
            else
                $worker->status = null;
            $worker->history = $history;

        }
        return ['status' => true, 'data' => $workers];
    }

    public function editDegreesWorker(Request $request){
        $id = $request->get('id', null);
        $status = $request->get('status', null);
        if ($id === null || $status === null)
            return ['status' => false];

        $res = DB::table('degrees_worker')->insert(['worker_id' => $id, 'status' => $status, 'date_begin' => date('Y-m-d')]);
        return ['status' => (boolean)$res];
    }

    public function getPositionWorker(Request $request){
        $workers = DB::table('worker')->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $history = DB::table('position_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->all();
            if (count($history) > 0)
                $worker->position_id = $history[0]->position_id;
            else
                $worker->position_id = null;
            $worker->history = $history;
        }
        return ['status' => true, 'data' => $workers];
    }

    public function editPositionWorker(Request $request){
        $id = $request->get('id', null);
        $positionId = $request->get('position_id', null);
        if ($id === null || $positionId === null)
            return ['status' => false];

        $res = DB::table('position_worker')->insert(['worker_id' => $id, 'position_id' => $positionId, 'date_begin' => date('Y-m-d')]);
        return ['status' => (boolean)$res];
    }

    public function getRateWorker(Request $request){
        $workers = DB::table('worker')->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $history = DB::table('rate_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->all();
            if (count($history) > 0)
                $worker->hours = $history[0]->hours;
            else
                $worker->hours = null;
            $worker->history = $history;
        }
        return ['status' => true, 'data' => $workers];
    }

    public function editRateWorker(Request $request){
        $id = $request->get('id', null);
        $hours = $request->get('hours', null);
        if ($id === null || $hours === null)
            return ['status' => false];

        $res = DB::table('rate_worker')->insert(['worker_id' => $id, 'hours' => $hours, 'date_begin' => date('Y-m-d')]);
        return ['status' => (boolean)$res];
    }

    public function getStaffWorker(Request $request){
        $workers = DB::table('worker')->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $history = DB::table('staff_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->all();
            if (count($history) > 0)
                $worker->status = $history[0]->status;
            else
                $worker->status = null;
            $worker->history = $history;
        }
        return ['status' => true, 'data' => $workers];
    }

    public function editStaffWorker(Request $request){
        $id = $request->get('id', null);
        $status = $request->get('status', null);
        if ($id === null || $status === null)
            return ['status' => false];

        $res = DB::table('staff_worker')->insert(['worker_id' => $id, 'status' => $status, 'date_begin' => date('Y-m-d')]);
        return ['status' => (boolean)$res];
    }

    public function getTrainedWorker(Request $request){
        $workers = DB::table('worker')->orderBy('fio')->get()->all();
        foreach ($workers as &$worker){
            $history = DB::table('trained_worker')->where('worker_id', $worker->id)->orderBy('date_begin', 'desc')->get()->all();
            if (count($history) > 0)
                $worker->status = $history[0]->status;
            else
                $worker->status = null;
            $worker->history = $history;
        }
        return ['status' => true, 'data' => $workers];
    }

    public function editTrainedWorker(Request $request){
        $id = $request->get('id', null);
        $status = $request->get('status', null);
        if ($id === null || $status === null)
            return ['status' => false];

        $res = DB::table('trained_worker')->insert(['worker_id' => $id, 'status' => $status, 'date_begin' => date('Y-m-d')]);
        return ['status' => (boolean)$res];
    }

    public function clearCoefOld(Request $request){
        DB::table('coefficients')->where('type', 1)->delete();
        return ['status' => true];
    }

    public function setCoefKaf(Request $request){
        $workerId = $request->get('worker_id', null);
        $disciplineId = $request->get('discipline_id', null);
        $typeClassId = $request->get('type_class_id', null);
        $specialityId = $request->get('speciality_id', null);
        $coefficient = $request->get('coefficient', null);
        $validator = Validator::make([
            'worker_id' => $workerId,
            'discipline_id' => $disciplineId,
            'type_class_id' => $typeClassId,
            'speciality_id' => $specialityId,
            'coefficient' => $coefficient,
        ],[
            'worker_id' => 'required|integer',
            'discipline_id' => 'required|integer',
            'type_class_id' => 'required|integer',
            'speciality_id' => 'required|integer',
            'coefficient' => 'required|numeric',
        ]);

        if ($validator->fails())
            return ['status' => false, 'errors' => 'Не верные параметры'];

        $coef = DB::table('coefficients')->where([['worker_id', $workerId], ['discipline_id', $disciplineId], ['type_class_id', $typeClassId], ['speciality_id', $specialityId], ['type', 3]])->get()->first();
        if ($coef)
            DB::table('coefficients')->where('id', $coef->id)->update(['coefficient' => $coefficient]);
        else
            DB::table('coefficients')->insert(['worker_id' => $workerId, 'discipline_id' => $disciplineId, 'type_class_id' => $typeClassId, 'speciality_id' => $specialityId, 'type' => 3, 'coefficient' => $coefficient]);
        return ['status' => true];
    }

}
