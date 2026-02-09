<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcknowledgementReceipt;
use App\Models\ClientVerification;

class ARController extends Controller
{
    public function list()
    {
        // Get all AR records (paginate if needed in future)
        $data['getRecord'] = AcknowledgementReceipt::orderBy('created_at', 'desc')->get();

        // Add a header title for the view
        $data['header_title'] = "Acknowledgement Receipt List";

        return view('staff.ar.list', $data);
    }

    public function viewingList()
    {
        $data['getRecord'] = AcknowledgementReceipt::with('clientVerification.client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = "Saved Acknowledgement Receipts";
        return view('staff.ar.viewing_list', $data);
    }

    public function view($id)
    {
        $record = AcknowledgementReceipt::with('clientVerification.client')->findOrFail($id);
        $data['header_title'] = "ACKNOWLEDGEMENT RECEIPT View";
        return view('staff.ar.view', compact('record', 'data'));
    }

    public function edit($id)
    {
        $record = AcknowledgementReceipt::with('clientVerification.client')->findOrFail($id);
        return view('staff.ar.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'recipient_name' => 'required|string',
            'barangay' => 'required|string',
            'amount' => 'required|numeric',
            'amount_words' => 'required|string',
            'type' => 'required|string',
            'day_received' => 'required|string',
            'month_received' => 'required|string',
            'year_received' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $ar = AcknowledgementReceipt::findOrFail($id);
        $ar->recipient_name = $request->recipient_name;
        $ar->barangay = $request->barangay;
        $ar->amount = $request->amount;
        $ar->amount_words = $request->amount_words;
        $ar->type = $request->type;
        $ar->day_received = $request->day_received;
        $ar->month_received = $request->month_received;
        $ar->year_received = $request->year_received;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ar_photos'), $filename);
            $ar->photo = 'uploads/ar_photos/' . $filename;
        }

        $ar->save();

        return redirect('staff/ar/viewing-list')->with('success', 'Acknowledgement Receipt updated successfully.');
    }


    public function create()
    {
        $data['header_title'] = 'Add Acknowledgement Receipt';

        // If you want to select clients from existing verified ones
        $data['clients'] = \App\Models\ClientVerification::with('client')->get();

        return view('staff.ar.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_verification_id' => 'required|exists:client_verifications,id',
            'barangay' => 'required|string',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'amount_words' => 'required|string',
            'day_received' => 'required',
            'month_received' => 'required|string',
            'year_received' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $ar = new AcknowledgementReceipt();
        // Auto-populate recipient name
        $clientVerification = \App\Models\ClientVerification::with('client')->find($request->client_verification_id);
        $ar->recipient_name = $clientVerification?->client?->full_name ?? 'Unknown';

        $ar->client_verification_id = $request->client_verification_id;
        $ar->barangay = $request->barangay;
        $ar->type = $request->type;
        $ar->amount = $request->amount;
        $ar->amount_words = $request->amount_words;
        $ar->day_received = $request->day_received;
        $ar->month_received = $request->month_received;
        $ar->year_received = $request->year_received;


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ar_photos'), $filename);
            $ar->photo = 'uploads/ar_photos/' . $filename;
        }

        $ar->save();

        return redirect('staff/ar/viewing-list')->with('success', 'Acknowledgement Receipt added successfully.');
    }

    public function delete($id)
    {
        $ar = \App\Models\AcknowledgementReceipt::find($id);

        if (!$ar) {
            return redirect()->back()->with('error', 'Acknowledgement Receipt not found.');
        }

        // Optional: delete photo file from server if exists
        if ($ar->photo && file_exists(public_path($ar->photo))) {
            unlink(public_path($ar->photo));
        }

        $ar->delete();

        return redirect()->back()->with('success', 'Acknowledgement Receipt deleted successfully.');
    }
}
