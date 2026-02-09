<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', // <--- ADD THIS
        'is_delete', // <--- ADD THIS
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getTotalUser($user_type)
    {
        return self::select('users.id')
            ->where('user_type', '=', $user_type)
            ->where('is_delete', '=', 0)
            ->count();
    }

    static public function getSingleClass($id)
    {
        return self::select('users.*', 'class.amount', 'class.name as class_name')
            ->join('class', 'class.id', 'users.class_id')
            ->where('users.id', '=', $id)
            ->first();
    }

    static public function getAdmin($name = null, $email = null, $date = null)
    {
        $query = self::select('users.*')
            ->where('user_type', '=', 1)
            ->where('is_delete', '=', 0);

        if (!empty($name)) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        if (!empty($email)) {
            $query = $query->where('email', 'like', '%' . $email . '%');
        }

        if (!empty($date)) {
            $query = $query->whereDate('created_at', '=', $date);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate(20);

        return $result;
    }

    static public function getParent($name = null, $email = null, $gender = null, $occupation = null, $address)
    {
        $query = self::select('users.*')
            ->where('user_type', '=', 4)
            ->where('is_delete', '=', 0);


        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }

        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }

        if (!empty($gender)) {
            $query = $query->where('users.gender', '=', $gender);
        }

        if (!empty($occupation)) {
            $query = $query->where('users.occupation', 'like', '%' . $occupation . '%');
        }

        if (!empty($address)) {
            $query = $query->where('users.address', 'like', '%' . $address . '%');
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate(20);

        return $result;
    }

    static public function getCollectFeesStudent($request)
    {
        $query = self::select('users.*', 'class.name as class_name', 'class.amount')
            ->leftJoin('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

        if (!empty($request->get('class_id'))) {
            $query = $query->where('users.class_id', '=', $request->get('class_id'));
        }

        if (!empty($request->get('name'))) {
            $query = $query->where('users.name', 'like', '%' . $request->get('name') . '%');
        }

        $result = $query->orderBy('users.name', 'asc')
            ->paginate(50);

        return $result;
    }

    static public function getStudent($name = null, $email = null, $class = null, $gender = null, $date_of_birth = null)
    {
        $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')

            ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->leftJoin('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }

        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }

        if (!empty($class)) {
            $query = $query->where('class.name', 'like', '%' . $class . '%');
        }

        if (!empty($gender)) {
            $query = $query->where('users.gender', '=', $gender);
        }

        if (!empty($date_of_birth)) {
            $query = $query->whereDate('users.date_of_birth', '=', $date_of_birth);
        }

        $result = $query->orderBy('users.id', 'desc')
            ->paginate(20);

        return $result;
    }

    static public function getTeacher($name = null, $email = null, $gender = null, $marital_status = null, $address = null, $status = null, $admission_date = null, $date = null)
    {
        $query = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);


        if (!empty($name)) {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }

        if (!empty($email)) {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }

        if (!empty($gender)) {
            $query = $query->where('users.gender', '=', $gender);
        }

        if (!empty($marital_status)) {
            $query = $query->where('users.marital_status', 'like', '%' . $marital_status . '%');
        }

        if (!empty($address)) {
            $query = $query->where('users.address', 'like', '%' . $address . '%');
        }

        if (!empty($status)) {
            $status = (($status) == 100) ? 0 : 1;
            $query = $query->where('users.status', '=', $status);
        }

        if (!empty($admission_date)) {
            $query = $query->whereDate('users.admission_date', '=', $admission_date);
        }

        if (!empty($date)) {
            $query = $query->whereDate('users.created_at', '=', $date);
        }

        $result = $query->orderBy('users.id', 'desc')
            ->paginate(20);

        return $result;
    }

    static public function getStudentClass($class_id)
    {
        return self::select('users.id', 'users.name', 'users.last_name')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->where('users.class_id', '=', $class_id)
            ->orderBy('users.id', 'desc')
            ->get();
    }

    static public function getTeacherStudent($teacher_id)
    {
        $query = self::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);
        $result = $query->orderBy('users.id', 'desc')
            ->groupBy('users.id')
            ->paginate(20);

        return $result;
    }


    static public function getTeacherStudentCount($teacher_id)
    {
        $return = self::select('users.id')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->count();

        return $return;
    }

    static public function getTeacherClass()
    {
        $query = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);
        $result = $query->orderBy('users.id', 'desc')
            ->get();

        return $result;
    }

    static public function getSearchStudent($searchData)
    {

        if (!empty($id) || !empty($name) || !empty($email)) {
            $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
                ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
                ->leftJoin('class', 'class.id', '=', 'users.class_id', 'left')
                ->where('users.user_type', '=', 3)
                ->where('users.is_delete', '=', 0);

            if (!empty($id)) {
                $query = $query->where('users.id', '=', $id);
            }

            if (!empty($name)) {
                $query = $query->where('users.name', 'like', '%' . $name . '%');
            }

            if (!empty($email)) {
                $query = $query->where('users.email', 'like', '%' . $email . '%');
            }

            $result = $query->orderBy('users.id', 'desc')
                ->limit(50)
                ->get();

            return $result;
        }

        $query = self::select('users.*')
            ->where('user_type', '=', 3)
            ->where('is_delete', '=', 0);

        foreach ($searchData as $field => $value) {
            if (!empty($value)) {
                $query->where('users.' . $field, 'like', '%' . $value . '%');
            }
        }

        $result = $query->orderBy('id', 'desc')->paginate(20);

        return $result;
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    static public function getMyStudent($parent_id)
    {
        return self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id')
            ->leftJoin('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();
    }

    static public function getMyStudentCount($parent_id)
    {
        return self::select('users.id')
            ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id')
            ->leftJoin('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->count();
    }

    static public function getMyStudentIds($parent_id)
    {
        $return = self::select('users.id')
            ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id')
            ->leftJoin('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();

        $student_ids = array();
        foreach ($return as $value) {
            $student_ids[] = $value->id;

            return $student_ids;
        }
    }

    static public function getPaidAmount($student_id, $class_id)
    {
        return StudentAddFeesModel::getPaidAmount($student_id, $class_id);
    }

    static public function getEmailSingle($email)
    {
        return User::where('email', '=', $email)->first();
    }

    static public function getTokenSingle($remember_token)
    {
        return User::where('remember_token', '=', $remember_token)->first();
    }

    public function getProfile()
    {
        if (!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)) {
            return url('upload/profile/' . $this->profile_pic);
        } else {
            return "";
        }
    }

    static public function getAttendance($student_id, $class_id, $attendance_date)
    {
        return StudentAttendanceModel::CheckAlreadyAttendance($student_id, $class_id, $attendance_date);
    }

    public static function getStaff($name = null, $email = null, $date = null)
    {
        $query = self::where('user_type', 2)
            ->where('is_delete', 0);

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->orderBy('id', 'desc')->paginate(50);
    }
}
