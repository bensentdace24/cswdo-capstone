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
        set_time_limit(300); // Allow up to 5 minutes for processing

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $lines = file($path);
        if (empty($lines)) {
            return back()->with('error', 'CSV file is empty.');
        }

        $headerLine = array_shift($lines);
        $delimiter = strpos($headerLine, "\t") !== false ? "\t" : ",";
        $rawHeaders = str_getcsv($headerLine, $delimiter);

        // Friendly mapping: CSV Label => Database Column
        $fieldMap = [
            'client_id'              => 'client_id',
            'client id'              => 'client_id',
            'barangay'               => 'barangay',
            'amount'                 => 'amount',
            'type'                   => 'type' ,
            'assistance type'        => 'type',
            'day_received'           => 'day_received',
            'day'                    => 'day_received',
            'month_received'         => 'month_received',
            'month'                  => 'month_received',
            'year_received'          => 'year_received',
            'year'                   => 'year_received',
            'recipient_name'         => 'recipient_name',
            'recipient'              => 'recipient_name',
            'amount_words'           => 'amount_words',
            'amount in words'        => 'amount_words',
            'client_verification_id' => 'client_verification_id',
        ];

        $headers = [];
        foreach ($rawHeaders as $index => $header) {
            // Strip BOM if present
            if ($index === 0) { $header = preg_replace('/^\xEF\xBB\xBF/', '', $header); }
            $cleanHeader = strtolower(trim($header));
            $headers[] = $fieldMap[$cleanHeader] ?? $cleanHeader;
        }

        DB::beginTransaction();
        try {
            $importedCount = 0;
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                
                $row = str_getcsv($line, $delimiter);
                if (count($headers) !== count($row)) continue;
                
                $rowData = array_combine($headers, array_map('trim', $row));
                $clientId = $rowData['client_id'] ?? '';

                if (empty($clientId) || !is_numeric($clientId)) continue;
                if (!DB::table('clients')->where('id', $clientId)->exists()) continue;

                $rawAmount = $rowData['amount'] ?? '0';
                $cleanAmount = (float) preg_replace('/[^\d.]/', '', $rawAmount);

                $day   = $rowData['day_received'] ?? '';
                $month = $rowData['month_received'] ?? '';
                $year  = $rowData['year_received'] ?? '';

                if (!empty($day) && !empty($month) && !empty($year)) {
                    $monthNumber = is_numeric($month) ? $month : date('m', strtotime($month));
                    $assistedDate = sprintf('%04d-%02d-%02d', $year, $monthNumber, $day);
                } else {
                    $assistedDate = now()->format('Y-m-d');
                }

                $verificationId = $rowData['client_verification_id'] ?? null;
                if (!$verificationId || !is_numeric($verificationId)) {
                    $verificationId = DB::table('client_verifications')
                        ->where('client_id', $clientId)
                        ->orderByDesc('id')
                        ->value('id');
                    
                    if (!$verificationId) {
                        $verificationId = DB::table('client_verifications')->insertGetId([
                            'client_id'         => $clientId,
                            'problem_presented' => 'Imported via CSV',
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);
                    }
                }

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
                    'is_imported'            => true,
                ]);

                ClientAssistanceLog::create([
                    'client_id'   => $clientId,
                    'assisted_at' => $assistedDate,
                    'type'        => $rowData['type'] ?? '',
                    'created_at'  => $assistedDate . ' ' . now()->format('H:i:s'),
                    'updated_at'  => now(),
                    'is_imported' => true,
                ]);

                $importedCount++;
            }

            DB::commit();
            
            $pythonPath = config('python.python_path', 'python');
            shell_exec("\"$pythonPath\" \"" . public_path('python/kmeans_cluster.py') . "\" 2>&1");
            shell_exec("\"$pythonPath\" \"" . public_path('python/random_forest_classifier.py') . "\" 2>&1");
            shell_exec("\"$pythonPath\" \"" . public_path('python/cluster_transactions_all_barangays.py') . "\" 2>&1");

            DB::table('ai_updates')->updateOrInsert(['id' => 1], ['updated_at' => now()]);

            return back()->with('success', "✅ Successfully imported $importedCount records and updated analytics!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    private function normalizeBoolean($value)
    {
        if (is_null($value)) return 0;
        $value = strtolower(trim($value));
        if (in_array($value, ['1', 'true', 'yes', 'y', 'checked'])) {
            return 1;
        }
        return 0;
    }

    public function importClientsCsv(Request $request)
    {
        set_time_limit(300); // Allow up to 5 minutes for processing

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $fieldMap = [
            'full_name'              => 'full_name',
            'full name'              => 'full_name',
            'name'                   => 'full_name',
            'address'                => 'address',
            'age'                    => 'age',
            'sex'                    => 'sex',
            'gender'                 => 'sex',
            'birthdate'              => 'birthdate',
            'birth date'             => 'birthdate',
            'is_ips'                 => 'is_ips',
            'ips'                    => 'is_ips',
            'ips member'             => 'is_ips',
            'is_4ps'                 => 'is_4ps',
            '4ps'                    => 'is_4ps',
            '4ps member'             => 'is_4ps',
            'civil_status'           => 'civil_status',
            'civil status'           => 'civil_status',
            'contact_number'         => 'contact_number',
            'contact'                => 'contact_number',
            'birthplace'             => 'birthplace',
            'birth place'            => 'birthplace',
            'educational_attainment' => 'educational_attainment',
            'education'              => 'educational_attainment',
            'occupation'             => 'occupation',
            'religion'               => 'religion',
        ];

        if (($handle = fopen($path, 'r')) !== FALSE) {
            // Read the first line to detect delimiter
            $firstLine = fgets($handle);
            rewind($handle);

            $delimiters = [",", ";", "\t"];
            $delimiter = ",";
            $maxCount = 0;
            foreach ($delimiters as $d) {
                $count = count(str_getcsv($firstLine, $d));
                if ($count > $maxCount) {
                    $maxCount = $count;
                    $delimiter = $d;
                }
            }

            $rawHeaders = fgetcsv($handle, 1000, $delimiter);
            if (!$rawHeaders) {
                fclose($handle);
                return back()->with('error', 'CSV file is empty or invalid.');
            }

            $headers = [];
            foreach ($rawHeaders as $index => $header) {
                // Strip UTF-8 BOM from the first header if present
                if ($index === 0) {
                    $header = preg_replace('/^\xEF\xBB\xBF/', '', $header);
                }
                $cleanHeader = strtolower(trim($header));
                $headers[] = $fieldMap[$cleanHeader] ?? $cleanHeader;
            }

            // Validate Required Headers
            $requiredHeaders = ['full_name'];
            foreach ($requiredHeaders as $required) {
                if (!in_array($required, $headers)) {
                    $friendlyName = array_search($required, $fieldMap) ?: $required;
                    fclose($handle);
                    return back()->with('error', "Missing required column: $friendlyName");
                }
            }

            $importedCount = 0;
            $skippedCount = 0;
            $errorLogs = [];
            $rowNumber = 1;

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                $rowNumber++;
                if (count($headers) !== count($row)) {
                    $errorLogs[] = "Row {$rowNumber}: Column count mismatch.";
                    continue; 
                }
                
                $rowData = array_combine($headers, array_map(function($val) {
                    $trimmed = trim($val);
                    return $trimmed === '' ? null : $trimmed;
                }, $row));
                
                $fullName = $rowData['full_name'] ?? null;

                if (empty($fullName)) {
                    $errorLogs[] = "Row {$rowNumber}: Full Name is required.";
                    continue;
                }

                $age = $rowData['age'] ?? null;
                $sex = $rowData['sex'] ?? null;
                $birthdate = $rowData['birthdate'] ?? null;

                // 🔍 Stronger Duplicate Check: Name + Birthdate OR Name + Age + Sex
                $query = Client::where('full_name', $fullName);
                if ($birthdate) {
                    $query->where('birthdate', $birthdate);
                } else {
                    $query->where('age', $age)->where('sex', $sex);
                }

                if ($query->exists()) {
                    $skippedCount++;
                    continue;
                }

                DB::beginTransaction();
                try {
                    Client::create([
                        'full_name'              => $fullName,
                        'address'                => $rowData['address'] ?? null,
                        'is_ips'                 => $this->normalizeBoolean($rowData['is_ips'] ?? null),
                        'is_4ps'                 => $this->normalizeBoolean($rowData['is_4ps'] ?? null),
                        'age'                    => $age,
                        'birthplace'             => $rowData['birthplace'] ?? null,
                        'contact_number'         => $rowData['contact_number'] ?? null,
                        'educational_attainment' => $rowData['educational_attainment'] ?? null,
                        'occupation'             => $rowData['occupation'] ?? null,
                        'religion'               => $rowData['religion'] ?? null,
                        'sex'                    => $sex,
                        'civil_status'           => $rowData['civil_status'] ?? null,
                        'birthdate'              => $birthdate,
                        'created_at'             => now(),
                        'updated_at'             => now(),
                    ]);

                    DB::commit();
                    $importedCount++;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errorLogs[] = "Row {$rowNumber}: " . $e->getMessage();
                }
            }
            fclose($handle);

            $message = "✅ Import Complete! $importedCount added, $skippedCount duplicates skipped.";
            if (count($errorLogs) > 0) {
                $message .= " ⚠️ " . count($errorLogs) . " rows failed.";
            }

            return back()->with([
                'success' => $message,
                'import_errors' => $errorLogs
            ]);
        }

        return back()->with('error', 'Could not open CSV file.');
    }

}
