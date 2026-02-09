<?php

namespace App\Http\Controllers;

use App\Models\ClientVerification;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientVerificationController extends Controller
{
    public function list($client_id = null)
    {
        $query = ClientVerification::with('client')->orderBy('created_at', 'desc');

        if ($client_id) {
            $query->where('client_id', $client_id);
            $client = Client::findOrFail($client_id); // fetch client for the add link
        } else {
            $client = null;
        }

        $getRecord = $query->paginate(50);
        $header_title = "Beneficiaries List";

        return view('admin.client_verification.list', compact('getRecord', 'header_title', 'client'));
    }

    public function add($client_id)
    {
        $client = Client::findOrFail($client_id);
        // These are the checkboxes you want to show in the form (based on the scanned form image)
        $client_checks = [
            'understand_questions' => 'Client understands questions easily',
            'good_clothes' => 'Client wearing good and comfortable clothes',
            'presentable' => 'Well presentable and clearly answer the questions',
            'solo_parent' => 'Client is a Solo Parent',
            'physically_handicapped' => 'Physically handicapped with clothes',
            'senior_citizen' => 'Client is a Senior Citizen',
            'wheelchair' => 'Client is with wheelchair',
            'unkempt' => 'Client is unkept',
            'pwd' => 'Client is a PWD',
            'crutches' => 'Client is with crutches',
        ];

        $community_checks = [
            'peaceful' => 'The community is peaceful',
            'urban_poor' => 'Client lives in an urban poor community',
            'transport_problem' => 'Transportation problem',
            'rural_area_south' => 'Client lives in a rural area (South)',
            'rural_area_north' => 'Client lives in a rural area (North)',
            'accessible' => 'The community is easy to access immediate needs (Medical, Education, Market)',
        ];

        return view('admin.client_verification.add', compact('client', 'client_checks', 'community_checks'));
    }

    public function insert(Request $request, $client_id)
    {
        $request->validate([
            'problem_presented' => 'required|string',
            'client_assessment' => 'array|nullable',
            'community_assessment' => 'array|nullable',
            'family_condition' => 'nullable|string',
            'disaster_date' => 'nullable|date',
            'disaster_type' => 'nullable|string',
            'household_type' => 'nullable|string',
            'living_with' => 'nullable|string',
            'damage_type' => 'nullable|string',
        ]);

        $verification = new ClientVerification();
        $verification->client_id = $client_id;
        $verification->problem_presented = $request->problem_presented;
        $verification->client_assessment = json_encode($request->client_assessment ?? []);
        $verification->community_assessment = json_encode($request->community_assessment ?? []);
        $verification->family_condition = $request->family_condition;
        $verification->disaster_date = $request->disaster_date;
        $verification->disaster_type = $request->disaster_type;
        $verification->household_type = $request->household_type;
        $verification->living_with = $request->living_with;
        $verification->damage_type = $request->damage_type;
        $verification->save();

        return redirect('admin/client_verification/list')->with('success', 'Beneficiary added successfully!');
    }

    public function edit($id)
    {
        $record = ClientVerification::with('client')->findOrFail($id);

        $client_checks = [
            'understands_questions' => 'Client understands easily the question',
            'well_dressed' => 'Client wearing good and comfortable clothes',
            'presentable' => 'Well presentable and clearly answers the questions',
            'solo_parent' => 'Client is a Solo Parent',
            'senior_citizen' => 'Client is a Senior Citizen',
            'pwd' => 'Client is a PWD',
            'wheelchair' => 'Client is with wheelchair',
            'crutches' => 'Client is with crutches',
            'unkempt' => 'Client is unkept',
            'handicapped' => 'Physically handicapped with clothes',
        ];

        $community_checks = [
            'peaceful' => 'The community is peaceful',
            'urban_poor' => 'Client lives in an urban poor community',
            'transport_problem' => 'Transportation problem',
            'rural_area_north' => 'Client lives in a rural area at North dist.',
            'rural_area_south' => 'Client lives in a rural area at South dist.',
            'accessible_needs' => 'Easy access to medical, education, market',
        ];

        $disaster_types = ['fire', 'flood', 'other'];
        $household_types = ['owned', 'rented', 'living_with'];
        $damage_types = ['partially', 'totally'];

        return view('admin.client_verification.edit', compact(
            'record',
            'client_checks',
            'community_checks',
            'disaster_types',
            'household_types',
            'damage_types',
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'problem_presented' => 'required|string',
            'client_assessment' => 'array|nullable',
            'community_assessment' => 'array|nullable',
            'family_condition' => 'nullable|string',
            'disaster_date' => 'nullable|date',
            'disaster_type' => 'array|nullable',
            'household_type' => 'array|nullable',
            'living_with' => 'nullable|string',
            'damage_type' => 'nullable|string',
        ]);

        $verification = ClientVerification::findOrFail($id);
        $verification->problem_presented = $request->problem_presented;
        $verification->client_assessment = json_encode($request->client_assessment ?? []);
        $verification->community_assessment = json_encode($request->community_assessment ?? []);
        $verification->family_condition = $request->family_condition;
        $verification->disaster_date = $request->disaster_date;
        $verification->disaster_type = json_encode($request->disaster_type ?? []);
        $verification->household_type = json_encode($request->household_type ?? []);
        $verification->living_with = $request->living_with;
        $verification->damage_type = $request->damage_type;
        $verification->save();

        return redirect('admin/client_verification/list')->with('success', 'Beneficiary updated successfully!');
    }

    public function delete($id)
    {
        $verification = ClientVerification::findOrFail($id);
        $verification->delete();

        return redirect()->back()->with('success', 'Beneficiary record deleted successfully!');
    }
}
