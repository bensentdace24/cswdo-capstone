<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use App\Models\SettingModel;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use Illuminate\Support\Facades\Redis;

class FeesCollectionController extends Controller
{
    public function collect_fees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass($request);

        if (!empty($request->all())) {
            $data['getRecord'] = User::getCollectFeesStudent($request);
        }

        $data['header_title'] = "Collect Fees";
        return view('admin.fees_collection.collect_fees', $data);
    }

    public function collect_fees_add($student_id)
    {
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;

        $data['header_title'] = "Add Collect Fees";
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        return view('admin.fees_collection.add_collect_fees', $data);
    }

    public function collect_fees_insert($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);

        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        if (!empty($request->amount)) {
            $RemainingAmount = $getStudent->amount - $paid_amount;
            if ($RemainingAmount >= $request->amount) {
                $remaining_amount_user = $RemainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $RemainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();

                return redirect()->back()->with('success', "Fees Successfully Add");
            } else {
                return redirect()->back()->with('error', "The entered amount exceeds the remaining balance. Please enter an amount equal to or less than the remaining balance.");
            }
        } else {
            return redirect()->back()->with('error', "You need to add your amount at least ₱1");
        }
    }

    // student side work

    public function CollectFeesStudent(Request $request)
    {
        $student_id = Auth::user()->id;

        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;

        $data['header_title'] = "Fees Collection";
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        return view('student.my_fees_collection', $data);
    }

    public function CollectFeesStudentPayment(Request $request)
    {
        $getStudent = User::getSingleClass(Auth::user()->id);

        $paid_amount = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        if (!empty($request->amount)) {
            $RemainingAmount = $getStudent->amount - $paid_amount;
            if ($RemainingAmount >= $request->amount) {
                $remaining_amount_user = $RemainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = Auth::user()->id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $RemainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();

                return redirect()->back()->with('success', "Your Payment Successfully Add");

                $getSetting = SettingModel::getSingle();
            } else {
                return redirect()->back()->with('error', "The entered amount exceeds the remaining balance. Please enter an amount equal to or less than the remaining balance.");
            }
        } else {
            return redirect()->back()->with('error', "You need to add your amount at least ₱1");
        }
    }

    // parent side work

    public function CollectFeesStudentParent($student_id, Request $request)
    {
        $getStudent = User::getSingle($student_id);
        $data['getStudent'] = $getStudent;

        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;

        $data['header_title'] = "Fees Collection";
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        return view('parent.my_fees_collection', $data);
    }

    public function CollectFeesStudentPaymentParent($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);

        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        if (!empty($request->amount)) {
            $RemainingAmount = $getStudent->amount - $paid_amount;
            if ($RemainingAmount >= $request->amount) {
                $remaining_amount_user = $RemainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $getStudent->id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $RemainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();

                return redirect()->back()->with('success', "Your Payment Successfully Add");

                $getSetting = SettingModel::getSingle();
            } else {
                return redirect()->back()->with('error', "The entered amount exceeds the remaining balance. Please enter an amount equal to or less than the remaining balance.");
            }
        } else {
            return redirect()->back()->with('error', "You need to add your amount at least ₱1");
        }
    }
}
