<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcknowledgementReceipt;
use Illuminate\Support\Facades\DB;
use App\Models\ClientAssistanceLog;
use App\Models\Client;
use Illuminate\Support\Facades\Log;


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
        
        // Read the whole file into an array
        $lines = file($path);
        if (empty($lines)) {
            return back()->with('error', 'CSV file is empty.');
        }

        // Get headers and determine delimiter (comma or tab)
        $headerLine = array_shift($lines);
        $delimiter = strpos($headerLine, "\t") !== false ? "\t" : ",";
        $headers = array_map('trim', str_getcsv($headerLine, $delimiter));

        DB::beginTransaction();
        try {
            $importedCount = 0;
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                
                $row = str_getcsv($line, $delimiter);
                if (count($headers) !== count($row)) continue;
                
                $rowData = array_combine($headers, $row);
                $clientId = trim($rowData['client_id'] ?? '');

                // ✅ Skip if client ID is missing or not numeric
                if (empty($clientId) || !is_numeric($clientId)) {
                    continue;
                }

                // ✅ Check if client exists in DB
                if (!DB::table('clients')->where('id', $clientId)->exists()) {
                    continue;
                }

                // 💰 Clean Amount (remove ₱, commas, spaces)
                $rawAmount = $rowData['amount'] ?? '0';
                $cleanAmount = (float) preg_replace('/[^\d.]/', '', $rawAmount);

                // 📅 Handle Dates
                $day   = trim($rowData['day_received'] ?? '');
                $month = trim($rowData['month_received'] ?? '');
                $year  = trim($rowData['year_received'] ?? '');

                if (!empty($day) && !empty($month) && !empty($year)) {
                    $monthNumber = is_numeric($month) ? $month : date('m', strtotime($month));
                    $assistedDate = sprintf('%04d-%02d-%02d', $year, $monthNumber, $day);
                } else {
                    $assistedDate = now()->format('Y-m-d');
                }

                // 🔍 Ensure client_verification_id exists (find latest if missing)
                $verificationId = $rowData['client_verification_id'] ?? null;
                if (!$verificationId || !is_numeric($verificationId)) {
                    $verificationId = DB::table('client_verifications')
                        ->where('client_id', $clientId)
                        ->orderByDesc('id')
                        ->value('id');
                    
                    // 🆕 If still no verification, create a default one automatically
                    if (!$verificationId) {
                        $verificationId = DB::table('client_verifications')->insertGetId([
                            'client_id'         => $clientId,
                            'problem_presented' => 'Imported via CSV',
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);
                    }
                }

                // ✅ Insert to acknowledgement_receipts
                AcknowledgementReceipt::create([
                    'client_id'              => $clientId,
                    'client_verification_id' => $verificationId,
                    'recipient_name'         => $rowData['recipient_name'] ?? '',
                    'barangay'               => $rowData['barangay'] ?? '',
                    'amount'                 => $cleanAmount,
                    'amount_words'           => $rowData['amount_words'] ?? '',
                    'type'                   => $rowData['type'] ?? '',
                    'day_received'           => $day,
                    'month_received'         => $month,
                    'year_received'          => $year,
                    'photo'                  => $rowData['photo'] ?? null,
                    'created_at'             => $assistedDate . ' ' . now()->format('H:i:s'),
                    'updated_at'             => now(),
                ]);
                // ✅ Insert to client_assistance_logs for Eligibility
                ClientAssistanceLog::create([
                    'client_id'   => $clientId,
                    'assisted_at' => $assistedDate,
                    'type'        => $rowData['type'] ?? '',
                    'created_at'  => $assistedDate . ' ' . now()->format('H:i:s'),
                    'updated_at'  => now(),
                ]);

                $importedCount++;
            }

            DB::commit();

            // ✅ UPDATE AI MODELS USING CONFIG PATH
            $pythonPath = config('python.python_path', 'python');
            $kmeansScript = public_path('python/kmeans_cluster.py');
            $rfScript = public_path('python/random_forest_classifier.py');
            $allBrgyScript = public_path('python/cluster_transactions_all_barangays.py');

            $out1 = shell_exec("\"$pythonPath\" \"$kmeansScript\" 2>&1");
            $out2 = shell_exec("\"$pythonPath\" \"$rfScript\" 2>&1");
            $out3 = shell_exec("\"$pythonPath\" \"$allBrgyScript\" 2>&1");

            Log::info("AI Import Update:\nKMeans: $out1\nRF: $out2\nAllBrgy: $out3");

            DB::table('ai_updates')->updateOrInsert(['id' => 1], ['updated_at' => now()]);

            return back()->with('success', "✅ Successfully imported $importedCount records and updated analytics!");
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
                    $existing = Client::where('full_name', $fullName)
                        ->where('age', $age)
                        ->where('sex', $sex)
                        ->first();

                    if ($existing) {
                        $skippedCount++;
                        continue;
                    }

                    // 🧾 Create new client
                    Client::create([
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
