<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';

    static public function CheckAlreadyAttendance($student_id, $class_id, $attendance_date)
    {
        return StudentAttendanceModel::where('student_id', '=', $student_id)->where('class_id', '=', $class_id)->where('attendance_date', '=', $attendance_date)->first();
    }

    static public function getRecord($student_name = null, $class_id = null, $attendance_date = null, $attendance_type = null)
    {
        $return = StudentAttendanceModel::select('student_attendance.*', 'class.name as class_name', 'student.name as student_name', 'student.last_name as student_last_name', 'createdby.name as created_name')
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('users as createdby', 'createdby.id', '=', 'student_attendance.created_by');

        if (!empty($student_name)) {
            $return = $return->where('student.name', 'like', '%' . $student_name . '%');
        }

        if (!empty($class_id)) {
            $return = $return->where('student_attendance.class_id', '=', $class_id);
        }

        if (!empty($attendance_date)) {
            $return = $return->where('student_attendance.attendance_date', '=', $attendance_date);
        }

        if (!empty($attendance_type)) {
            $return = $return->where('student_attendance.attendance_type', '=', $attendance_type);
        }

        $return = $return->orderBy('student_attendance.id', 'desc')
            ->paginate(50);

        return $return;
    }

    static public function getRecordTeacher($class_ids, $student_name = null, $class_id = null, $attendance_date = null, $attendance_type = null)
    {
        if (!empty($class_ids)) {
            $return = StudentAttendanceModel::select('student_attendance.*', 'class.name as class_name', 'student.name as student_name', 'student.last_name as student_last_name', 'createdby.name as created_name')
                ->join('class', 'class.id', '=', 'student_attendance.class_id')
                ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
                ->join('users as createdby', 'createdby.id', '=', 'student_attendance.created_by')
                ->whereIn('student_attendance.class_id', $class_ids);

            if (!empty($student_name)) {
                $return = $return->where('student.name', 'like', '%' . $student_name . '%');
            }

            if (!empty($class_id)) {
                $return = $return->where('student_attendance.class_id', '=', $class_id);
            }

            if (!empty($attendance_date)) {
                $return = $return->where('student_attendance.attendance_date', '=', $attendance_date);
            }

            if (!empty($attendance_type)) {
                $return = $return->where('student_attendance.attendance_type', '=', $attendance_type);
            }

            $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(50);

            return $return;
        } else {
            return "";
        }
    }
}
