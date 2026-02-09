<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display Staff List
     */
    public function list(Request $request)
    {
        $data['getRecord'] = User::getStaff(
            $request->input('name'),
            $request->input('email'),
            $request->input('date')
        );

        $data['header_title'] = "Staff List";

        return view('admin.staff.list', $data);
    }

    /**
     * Add Staff View
     */
    public function add()
    {
        $data['header_title'] = "Add New Staff";
        return view('admin.staff.add', $data);
    }

    /**
     * Insert New Staff
     */
    public function insert(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'user_type' => 2,
            'is_delete' => 0,
        ]);

        return redirect('admin/staff/list')->with('success', "Staff created successfully");
    }

    /**
     * Edit Staff View
     */
    public function edit($id)
    {
        $staff = User::getSingle($id);

        if (empty($staff) || $staff->user_type != 2) {
            abort(404);
        }

        $data['getRecord'] = $staff;
        $data['header_title'] = "Edit Staff";

        return view('admin.staff.edit', $data);
    }

    /**
     * Update Staff Information
     */
    public function update($id, Request $request)
    {
        $staff = User::getSingle($id);
        if (!$staff || $staff->user_type != 2) {
            abort(404);
        }

        // Validate email and optional password
        $rules = [
            'email' => 'required|email|unique:users,email,' . $id,
        ];

        // Only validate password if user typed something
        if ($request->filled('new_password')) {
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        // Save changes
        $staff->name = $request->name;
        $staff->email = $request->email;

        if ($request->filled('new_password')) {
            $staff->password = bcrypt($request->new_password);
        }

        $staff->save();

        return redirect('admin/staff/list')->with('success', 'Staff successfully updated');
    }

    /**
     * Soft Delete Staff
     */
    public function delete($id)
    {
        $staff = User::getSingle($id);

        if (empty($staff) || $staff->user_type != 2) {
            abort(404);
        }

        $staff->is_delete = 1;
        $staff->save();

        return redirect()->back()->with('success', "Staff successfully deleted");
    }
}
