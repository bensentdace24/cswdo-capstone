<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Illuminate\Support\Facades\Auth;

class AssignClassTeacherController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = AssignClassTeacherModel::getRecord($request);

        $data['header_title'] = "Assign Class Teacher";
        return view('admin.assign_class_teacher.list', $data);
    }

    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();

        $data['header_title'] = "Add Assign Class Teacher";
        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(Request $request)
    {
        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }

            return redirect('admin/assign_class_teacher/list')->with('success', "Assign Class to Teacher Success");
        } else {
            return redirect()->back()->with('error', 'Due to some error please try again');
        }
    }

    public function delete($id)
    {
        $save = AssignClassTeacherModel::getSingle($id);

        if (!$save) {
            return redirect()->route('assign_class_teacher.list')->with('error', "Record not found");
        }

        $save->delete();

        return redirect()->route('assign_class_teacher.list')->with('success', "Assign Class to Teacher Successfully Deleted");
    }

    public function MyClassSubject()
    {
        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        $data['header_title'] = "My Class & Subject";

        return view('teacher.my_class_subject', $data);
    }
}
