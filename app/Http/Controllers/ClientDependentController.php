<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientDependent;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientDependentController extends Controller
{
    public function list($client_id)
    {
        $client = Client::findOrFail($client_id);
        $dependents = ClientDependent::where('client_id', $client_id)->paginate(50);
        $header_title = "Patient Dependent/s of: " . $client->full_name;
        return view('admin.client_dependents.list', compact('client', 'dependents', 'header_title'));
    }

    public function index()
    {
        $dependents = ClientDependent::paginate(50);
        $header_title = "All Patient Dependents";
        return view('admin.client_dependents.list', compact('dependents', 'header_title'));
    }

    public function add($client_id)
    {
        $client = \App\Models\Client::findOrFail($client_id);
        return view('admin.client_dependents.add', compact('client'));
    }

    public function insert(Request $request, $client_id)
    {
        $client = \App\Models\Client::findOrFail($client_id);

        $request->validate([
            'dependent_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
            'relationship' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
        ]);

        $dependent = new \App\Models\ClientDependent();
        $dependent->client_id = $client->id;
        $dependent->dependent_name = $request->dependent_name;
        $dependent->age = $request->age;
        $dependent->status = $request->status;
        $dependent->relationship = $request->relationship;
        $dependent->occupation = $request->occupation;
        $dependent->birthday = $request->birthday;
        $dependent->save();

        return redirect('admin/client_dependents/list/' . $client->id)
            ->with('success', 'Patient Dependent added successfully!');
    }

    public function edit($id)
    {
        $getRecord = \App\Models\ClientDependent::findOrFail($id);
        $client = \App\Models\Client::findOrFail($getRecord->client_id);

        return view('admin.client_dependents.edit', compact('getRecord', 'client'));
    }

    public function update($id, Request $request)
    {
        $dependent = \App\Models\ClientDependent::findOrFail($id);
        $client_id = $dependent->client_id;

        $request->validate([
            'dependent_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
            'relationship' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
        ]);

        $dependent->dependent_name = $request->dependent_name;
        $dependent->age = $request->age;
        $dependent->status = $request->status;
        $dependent->relationship = $request->relationship;
        $dependent->occupation = $request->occupation;
        $dependent->birthday = $request->birthday;
        $dependent->save();

        return redirect('admin/client_dependents/list/' . $client_id)
            ->with('success', 'Dependent updated successfully!');
    }

    public function delete($id)
    {
        $dependent = \App\Models\ClientDependent::findOrFail($id);
        $client_id = $dependent->client_id;
        $dependent->delete();

        return redirect('admin/client_dependents/list/' . $client_id)
            ->with('success', 'Dependent deleted successfully!');
    }
}
