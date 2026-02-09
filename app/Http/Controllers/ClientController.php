<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients with filters and optimized eligibility check.
     */
    public function list(Request $request)
    {
        // 1. Start the query builder
        $query = \App\Models\Client::query();

        // --- FILTERS (Keep all your existing filter logic) ---
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

        // --- EXECUTE QUERY AND OPTIMIZE PERFORMANCE ---
        $clients = $query
            // CRUCIAL FIX: Eager load assistanceLogs to enable the fast eligibility check
            // and fix the N+1 query issue.
            ->with('assistanceLogs')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // NOTE: The lines that were computing and overwriting the query were removed.
        // The `$clients` variable now holds the correctly filtered and eager-loaded results.

        $data['getRecord'] = $clients;

        return view('admin.client.list', $data);
    }

    /**
     * Display the form to add a new client.
     */
    public function add()
    {
        $data['header_title'] = "Add New Client";
        return view('admin.client.add', $data);
    }

    /**
     * Store a newly created client in the database.
     */
    public function insert(Request $request)
    {
        // Validate user input
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

        // 🔍 Check for existing client with same name, age, and sex
        $existing = \App\Models\Client::where('full_name', $request->full_name)
            ->where('age', $request->age)
            ->where('sex', $request->sex)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Client with the same age and sex already exists.');
        }

        // 🧾 Create new client
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

        return redirect('admin/client/list')->with('success', 'Client added successfully!');
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        $data['getRecord'] = Client::find($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Client";
            return view('admin.client.edit', $data);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified client in the database.
     */
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
        return redirect('admin/client/list')->with('success', 'Client updated successfully!');
    }

    /**
     * Delete the specified client.
     */
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

    /**
     * Display the specified client's details.
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        // Use the accessors for eligibility check
        return view('admin.client.show', [
            'client' => $client,
            'eligible' => $client->eligibility_status,
            'daysLeft' => $client->days_until_eligible,
        ]);
    }
}
