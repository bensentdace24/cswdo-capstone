<?php

namespace App\Http\Controllers;

use App\Models\ClientRequirement;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientRequirementController extends Controller
{
    public function index($client_id)
    {
        $client = Client::findOrFail($client_id);

        // Default requirement items (based on your official form)
        $defaultRequirements = [
            'barangay_certificate' => 'Barangay Certificate of Assistance to Individual in Crisis Situation',
            'medical_certificate' => 'Medical Certificate (Valid within 5 days)',
            'pharmacist_receipt' => 'Resita nga naay perma sa Pharmacist with Presyo (Valid within 5 days)',
            'valid_id' => 'Photocopy of Valid ID (Claimant and Patient)',
        ];

        // Automatically create missing requirement rows
        foreach ($defaultRequirements as $key => $label) {
            ClientRequirement::firstOrCreate([
                'client_id' => $client->id,
                'requirement_key' => $key,
            ], [
                'is_submitted' => false,
                'notes' => null,
            ]);
        }

        // Get all requirements for display
        $requirements = ClientRequirement::where('client_id', $client->id)->get();

        return view('admin.client.requirements', compact('client', 'requirements', 'defaultRequirements'));
    }


    public function update(Request $request, $client_id)
    {
        $client = Client::findOrFail($client_id);

        foreach ($request->is_submitted ?? [] as $req_id => $status) {
            $requirement = ClientRequirement::find($req_id);
            if ($requirement && $requirement->client_id == $client->id) {
                $requirement->update([
                    'is_submitted' => (bool) $status,
                    'notes' => $request->notes[$req_id] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Checklist updated successfully!');
    }

    public function showRequirements($id)
    {
        $client = Client::findOrFail($id);
        $requirements = ClientRequirement::where('client_id', $id)->get();

        return view('admin.client.requirements', compact('client', 'requirements'));
    }

    public function updateRequirements(Request $request, $id)
    {
        foreach ($request->is_submitted ?? [] as $reqId => $value) {
            $req = ClientRequirement::find($reqId);
            if ($req && $req->client_id == $id) {
                $req->is_submitted = true;
                $req->notes = $request->notes[$reqId] ?? null;
                $req->save();
            }
        }

        // Unchecked items become false
        $allReqs = ClientRequirement::where('client_id', $id)->get();
        foreach ($allReqs as $r) {
            if (!isset($request->is_submitted[$r->id])) {
                $r->is_submitted = false;
                $r->notes = $request->notes[$r->id] ?? null;
                $r->save();
            }
        }

        return redirect()->route('client.requirements', $id)->with('success', 'Checklist updated successfully!');
    }

    public function missingRequirements(Request $request)
    {
        // Required checklist items
        $requirementKeys = [
            'barangay_certificate',
            'medical_certificate',
            'pharmacist_receipt',
            'valid_id',
        ];

        // Load ALL clients + requirements
        $clients = Client::with('requirements')
            ->when($request->search, function ($query) use ($request) {
                $query->where('full_name', 'LIKE', "%{$request->search}%");
            })
            ->get();

        // Filter who has missing requirements
        $clients = $clients->filter(function ($client) use ($requirementKeys) {
            foreach ($requirementKeys as $key) {
                $req = $client->requirements->firstWhere('requirement_key', $key);
                if (!$req || !$req->is_submitted) {
                    return true; // Has missing requirement
                }
            }
            return false; // Full complete, exclude
        })->values();

        return view('admin.client.missing-requirements', compact('clients', 'requirementKeys'));
    }
}
