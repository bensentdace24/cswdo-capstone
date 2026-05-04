<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcknowledgementReceipt;
use App\Models\ClientVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ARController extends Controller
{
    /**
     * Helper to trigger AI Updates
     */
    private function updateAI()
    {
        try {
            $pythonPath = config('python.python_path', 'python');
            $kmeansScript = public_path('python/kmeans_cluster.py');
            $rfScript = public_path('python/random_forest_classifier.py');
            $allBrgyScript = public_path('python/cluster_transactions_all_barangays.py');

            $out1 = shell_exec("\"$pythonPath\" \"$kmeansScript\" 2>&1");
            $out2 = shell_exec("\"$pythonPath\" \"$rfScript\" 2>&1");
            $out3 = shell_exec("\"$pythonPath\" \"$allBrgyScript\" 2>&1");

            Log::info("AI Manual Update (Staff):\nKMeans: $out1\nRF: $out2\nAllBrgy: $out3");

            DB::table('ai_updates')->updateOrInsert(['id' => 1], ['updated_at' => now()]);
        } catch (\Exception $e) {
            Log::error("AI Update Failed (Staff): " . $e->getMessage());
        }
    }

    public function list()
    {
        $data['getRecord'] = AcknowledgementReceipt::orderBy('created_at', 'desc')->get();
        $data['header_title'] = "Acknowledgement Receipt List";

        return view('staff.ar.list', $data);
    }

    public function viewingList(Request $request)
    {
        $query = AcknowledgementReceipt::with(['clientVerification.client'])
            ->orderBy('created_at', 'desc');

        // Filter by client name
        if ($request->filled('search_name')) {
            $searchTerm = $request->search_name;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('recipient_name', 'like', "%$searchTerm%")
                    ->orWhereHas('clientVerification.client', function ($subQ) use ($searchTerm) {
                        $subQ->where('full_name', 'like', "%$searchTerm%");
                    });
            });
        }

        // Filter by type (USING EXISTING COLUMN)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('month_received', $request->month);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year_received', $request->year);
        }

        $data['getRecord'] = $query->get();
        $data['header_title'] = "Saved Acknowledgement Receipts";

        return view('staff.ar.viewing_list', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Add Acknowledgement Receipt';

        $data['clients'] = ClientVerification::with('client')
            ->orderBy('created_at', 'desc') // newest first
            ->get();

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

        // Check duplicate (same client + type + year)
        $existingAR = AcknowledgementReceipt::where('client_verification_id', $request->client_verification_id)
            ->where('type', $request->type)
            ->where('year_received', $request->year_received)
            ->first();

        if ($existingAR) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This client already has an Acknowledgement Receipt for this type and year.');
        }

        $ar = new AcknowledgementReceipt();

        $clientVerification = ClientVerification::with('client')->find($request->client_verification_id);
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

        $this->updateAI();

        return redirect('staff/ar/view/' . $ar->id . '?finance_officer_name=' . urlencode($request->finance_officer_name))
            ->with('success', 'Acknowledgement Receipt added successfully.');
    }

    public function view($id, Request $request)
    {
        $record = AcknowledgementReceipt::with('clientVerification.client')->findOrFail($id);
        $data['header_title'] = "ACKNOWLEDGEMENT RECEIPT View";

        // Get name from URL (?finance_officer_name=...)
        $finance_officer_name = $request->query('finance_officer_name');

        return view('staff.ar.view', compact('record', 'data', 'finance_officer_name'));
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
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'amount_words' => 'required|string',
            'day_received' => 'required|string',
            'month_received' => 'required|string',
            'year_received' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $ar = AcknowledgementReceipt::findOrFail($id);

        $ar->recipient_name = $request->recipient_name;
        $ar->barangay = $request->barangay;
        $ar->type = $request->type;
        $ar->amount = $request->amount;
        $ar->amount_words = $request->amount_words;
        $ar->day_received = $request->day_received;
        $ar->month_received = $request->month_received;
        $ar->year_received = $request->year_received;

        if ($request->hasFile('photo')) {
            if ($ar->photo && file_exists(public_path($ar->photo))) {
                unlink(public_path($ar->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ar_photos'), $filename);
            $ar->photo = 'uploads/ar_photos/' . $filename;
        }

        $ar->save();

        $this->updateAI();

        // ✅ Redirect back to view WITH finance officer name
        return redirect('staff/ar/view/' . $ar->id . '?finance_officer_name=' . urlencode($request->finance_officer_name))
            ->with('success', 'Acknowledgement Receipt updated successfully.');
    }

    public function delete($id)
    {
        $ar = AcknowledgementReceipt::find($id);

        if (!$ar) {
            return redirect()->back()->with('error', 'Acknowledgement Receipt not found.');
        }

        if ($ar->photo && file_exists(public_path($ar->photo))) {
            unlink(public_path($ar->photo));
        }

        $ar->delete();

        $this->updateAI();

        return redirect()->back()->with('success', 'Acknowledgement Receipt deleted successfully.');
    }
}
