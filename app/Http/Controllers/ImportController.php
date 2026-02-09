<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcknowledgementReceipt;
use Illuminate\Support\Facades\DB;
use App\Models\ClientAssistanceLog;


class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.import');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $headers = array_map('trim', array_shift($data));

        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                $rowData = array_combine($headers, $row);

                $clientId = $rowData['client_id'] ?? null;

                // ✅ Skip if client does not exist
                if (!DB::table('clients')->where('id', $clientId)->exists()) {
                    continue;
                }

                // ✅ Insert to acknowledgement_receipts
                AcknowledgementReceipt::create([
                    'client_id' => $clientId,
                    'client_verification_id' => $rowData['client_verification_id'] ?? null,
                    'recipient_name' => $rowData['recipient_name'] ?? '',
                    'barangay' => $rowData['barangay'] ?? '',
                    'amount' => $rowData['amount'] ?? 0,
                    'amount_words' => $rowData['amount_words'] ?? '',
                    'type' => $rowData['type'] ?? '',
                    'day_received' => $rowData['day_received'] ?? '',
                    'month_received' => $rowData['month_received'] ?? '',
                    'year_received' => $rowData['year_received'] ?? '',
                    'photo' => $rowData['photo'] ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ✅ Convert CSV date to actual timestamp for charts
                $day  = $rowData['day_received'] ?? null;
                $month = $rowData['month_received'] ?? null;
                $year = $rowData['year_received'] ?? null;

                if ($day && $month && $year) {
                    $monthNumber = date('m', strtotime($month));
                    $assistedDate = "$year-$monthNumber-$day";
                } else {
                    $assistedDate = now();
                }

                // ✅ Insert to client_assistance_logs using real date
                DB::table('client_assistance_logs')->insert([
                    'client_id' => $clientId,
                    'assisted_at' => $assistedDate,
                    'type' => $rowData['type'] ?? '',
                    'created_at' => $assistedDate,
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            // ✅ UPDATE AI MODELS IMMEDIATELY
            shell_exec("python " . public_path('python/kmeans_cluster.py'));
            shell_exec("python " . public_path('python/random_forest_classifier.py'));

            // ✅ Save last updated timestamp
            DB::table('ai_updates')->updateOrInsert([], ['updated_at' => now()]);

            return back()->with('success', '✅ CSV imported and analytics updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function deleteImportedData()
    {
        // ✅ Delete only rows that came from CSV import
        AcknowledgementReceipt::where('is_imported', true)->delete();
        ClientAssistanceLog::where('is_imported', true)->delete();

        // ✅ Recompute AI analytics so dashboard stays accurate
        shell_exec("python " . public_path('python/kmeans_cluster.py'));
        shell_exec("python " . public_path('python/random_forest_classifier.py'));

        DB::table('ai_updates')->updateOrInsert([], ['updated_at' => now()]);

        return back()->with('success', '✅ All imported data removed successfully!');
    }
}
