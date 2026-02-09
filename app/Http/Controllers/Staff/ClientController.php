<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function list(Request $request)
    {

        $query = \App\Models\Client::query();

        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%' . $request->full_name . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        if ($request->filled('birthplace')) {
            $query->where('birthplace', 'like', '%' . $request->birthplace . '%');
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('contact_number')) {
            $query->where('contact_number', 'like', '%' . $request->contact_number . '%');
        }

        if ($request->filled('is_4ps')) {
            $query->where('is_4ps', $request->is_4ps);
        }

        if ($request->filled('is_ips')) {
            $query->where('is_ips', $request->is_ips);
        }

        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', 'like', '%' . $request->educational_attainment . '%');
        }

        if ($request->filled('occupation')) {
            $query->where('occupation', 'like', '%' . $request->occupation . '%');
        }

        if ($request->filled('religion')) {
            $query->where('religion', 'like', '%' . $request->religion . '%');
        }

        if ($request->filled('birthdate')) {
            $query->whereDate('birthdate', $request->birthdate);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->filled('updated_at')) {
            $query->whereDate('updated_at', $request->updated_at);
        }

        $data['getRecord'] = $query->orderBy('id', 'desc')->paginate(10);
        $data['header_title'] = "Client List";
        return view('staff.client.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add New Client";
        return view('staff.client.add', $data);
    }


    public function insert(Request $request)
    {
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_ips' => 'nullable|boolean',
            'is_4ps' => 'nullable|boolean',
            'age' => 'nullable|integer',
            'birthplace' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'educational_attainment' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'sex' => 'nullable|string|max:10',
            'civil_status' => 'nullable|string|max:50',
            'birthdate' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        // Create and save the client
        $client = new \App\Models\Client();
        $client->full_name = $request->full_name;
        $client->address = $request->address;
        $client->is_ips = $request->is_ips ?? 0;
        $client->is_4ps = $request->is_4ps ?? 0;
        $client->age = $request->age;
        $client->birthplace = $request->birthplace;
        $client->contact_number = $request->contact_number;
        $client->educational_attainment = $request->educational_attainment;
        $client->occupation = $request->occupation;
        $client->religion = $request->religion;
        $client->sex = $request->sex;
        $client->civil_status = $request->civil_status;
        $client->birthdate = $request->birthdate;
        $client->save();

        // Redirect back to the client list with a success message
        return redirect('staff/client/list')->with('success', 'Client added successfully!');
    }

    public function edit($id)
    {
        $data['getRecord'] = Client::find($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Client";
            return view('staff.client.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_ips' => 'nullable|boolean',
            'is_4ps' => 'nullable|boolean',
            'age' => 'nullable|integer',
            'birthplace' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'educational_attainment' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'sex' => 'nullable|string|max:10',
            'civil_status' => 'nullable|string|max:50',
            'birthdate' => 'nullable|date',
        ]);

        // Find the client
        $client = Client::find($id);
        if (!$client) {
            abort(404);
        }

        // Update the client fields
        $client->full_name = $request->full_name;
        $client->address = $request->address;
        $client->is_ips = $request->is_ips ?? 0;
        $client->is_4ps = $request->is_4ps ?? 0;
        $client->age = $request->age;
        $client->birthplace = $request->birthplace;
        $client->contact_number = $request->contact_number;
        $client->educational_attainment = $request->educational_attainment;
        $client->occupation = $request->occupation;
        $client->religion = $request->religion;
        $client->sex = $request->sex;
        $client->civil_status = $request->civil_status;
        $client->birthdate = $request->birthdate;
        $client->save();

        // Redirect back to the client list with a success message
        return redirect('staff/client/list')->with('success', 'Client updated successfully!');
    }


    public function delete($id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return redirect()->back()->with('success', 'Client successfully deleted!');
        } else {
            abort(404);
        }
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);

        $lastLog = \App\Models\ClientAssistanceLog::where('client_id', $client->id)
            ->orderBy('assisted_at', 'desc')
            ->first();

        $eligible = true;
        $message = 'Eligible';
        $daysLeft = 0; // Initialize with 0

        if ($lastLog) {
            $now = Carbon::now();
            $lastDate = Carbon::parse($lastLog->assisted_at);
            $diffInDays = $lastDate->diffInDays($now);

            if ($diffInDays < 90) {
                $eligible = false;
                $daysLeft = 90 - $diffInDays; // Set the actual remaining days
                $message = "Not eligible yet. {$daysLeft} day(s) remaining.";
            }
        }

        // Add 'daysLeft' to the compact list below
        return view('staff.client.show', compact('client', 'eligible', 'message', 'daysLeft'));
    }
}
