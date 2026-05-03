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

    public function importClientsCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        // Use fopen to handle large files more memory-efficiently
        if (($handle = fopen($path, 'r')) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            $headers = array_map('trim', $headers);

            $importedCount = 0;
            $skippedCount = 0;

            DB::beginTransaction();
            try {
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (count($headers) !== count($row)) {
                        continue; // Skip malformed rows
                    }
                    
                    $rowData = array_combine($headers, $row);
                    $fullName = trim($rowData['full_name'] ?? '');

                    if (empty($fullName)) {
                        continue;
                    }

                    $age = $rowData['age'] ?? null;
                    $sex = $rowData['sex'] ?? null;

                    // 🔍 Check for existing client with same name, age, and sex to avoid duplicates
                    $existing = \App\Models\Client::where('full_name', $fullName)
                        ->where('age', $age)
                        ->where('sex', $sex)
                        ->first();

                    if ($existing) {
                        $skippedCount++;
                        continue;
                    }

                    // 🧾 Create new client
                    \App\Models\Client::create([
                        'full_name'              => $fullName,
                        'address'                => $rowData['address'] ?? null,
                        'is_ips'                 => isset($rowData['is_ips']) ? (int)$rowData['is_ips'] : 0,
                        'is_4ps'                 => isset($rowData['is_4ps']) ? (int)$rowData['is_4ps'] : 0,
                        'age'                    => $age,
                        'birthplace'             => $rowData['birthplace'] ?? null,
                        'contact_number'         => $rowData['contact_number'] ?? null,
                        'educational_attainment' => $rowData['educational_attainment'] ?? null,
                        'occupation'             => $rowData['occupation'] ?? null,
                        'religion'               => $rowData['religion'] ?? null,
                        'sex'                    => $sex,
                        'civil_status'           => $rowData['civil_status'] ?? null,
                        'birthdate'              => !empty($rowData['birthdate']) ? $rowData['birthdate'] : null,
                        'created_at'             => now(),
                        'updated_at'             => now(),
                    ]);

                    $importedCount++;
                }

                DB::commit();
                fclose($handle);

                return back()->with('success', "✅ Import Complete! $importedCount beneficiaries added, $skippedCount duplicates skipped.");
            } catch (\Exception $e) {
                DB::rollBack();
                fclose($handle);
                return back()->with('error', 'Import failed: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Could not open CSV file.');
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
