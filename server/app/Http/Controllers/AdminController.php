<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
