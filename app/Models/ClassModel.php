<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord(Request $request)
    {
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'class.created_by');

        if (!empty($request->get('name'))) {
            $return = $return->where('class.name', 'like', '%' . $request->get('name') . '%');
        }

        $date = $request->get('date');


        if (!empty($date)) {
            $return = $return->whereDate('class.created_at', '=', $date);
        }

        $return = $return->where('class.is_delete', '=', 0)
            ->orderBy('class.id', 'desc')
            ->paginate(20);

        return $return;
    }

    static public function getClass()
    {
        $return = ClassModel::select('class.*')
            ->join('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->orderBy('class.name', 'asc')
            ->get();

        return $return;
    }

    static public function getTotalClass()
    {
        $return = ClassModel::select('class.id')
            ->join('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->count();

        return $return;
    }
}
