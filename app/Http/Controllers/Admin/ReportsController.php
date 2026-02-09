<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClientAssistanceLog;
use App\Models\AcknowledgementReceipt;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $month = request('month');
        $year = request('year');
        $barangay = request('barangay');

        // ================================
        // 1) OFFICIAL BARANGAYS (for dropdown only)
        // ================================
        $officialBarangays = [
            'A. O. FLOIRENDO',
            'DATU ABDUL DADIA',
            'BUENAVISTA',
            'CACAO',
            'CAGANGOHAN',
            'CONSOLACION',
            'DAPCO',
            'GREDU (POBLACION)',
            'J.P. LAUREL',
            'KASILAK',
            'KATIPUNAN',
            'KATUALAN',
            'KAUSWAGAN',
            'KIOTOY',
            'LITTLE PANAY',
            'LOWER PANAGA (ROXAS)',
            'MABUNAO',
            'MADUAO',
            'MALATIVAS',
            'MANAY',
            'NANYO',
            'NEW MALAGA (DALISAY)',
            'NEW MALITBOG',
            'NEW PANDAN (POBLACION)',
            'NEW VISAYAS',
            'QUEZON',
            'SALVACION',
            'SAN FRANCISCO (POBLACION)',
            'SAN NICOLAS',
            'SAN PEDRO',
            'SAN ROQUE',
            'SAN VICENTE',
            'SANTA CRUZ',
            'SANTO NIÑO (POBLACION)',
            'SINDATON',
            'SOUTHERN DAVAO',
            'TAGPORE',
            'TIBUNGOL',
            'UPPER LICANAN',
            'WATERFALL',
        ];

        // Convert to objects for Blade
        $barangayList = collect($officialBarangays)->map(function ($b) {
            return (object)['barangay' => $b];
        });

        // ================================
        // 2) ALIASES: map OFFICIAL name -> possible DB values
        // ================================
        $barangayAliases = [
            'GREDU (POBLACION)' => ['GREDU'],
            'LOWER PANAGA (ROXAS)' => ['LOWER PANAGA'],
            'NEW MALAGA (DALISAY)' => ['NEW MALAGA', 'DALISAY'],
            'NEW PANDAN (POBLACION)' => ['NEW PANDAN'],
            'SAN FRANCISCO (POBLACION)' => ['SAN FRANCISCO'],
            'SANTO NIÑO (POBLACION)' => ['SANTO NIÑO', 'STO NIÑO'],
            'SOUTHERN DAVAO' => ['SOUTHERN DAVAO', 'SO. DAVAO', 'SOUTHER DAVAO', 'SOUTHERN AVAO'],
            'J.P. LAUREL' => ['J.P. LAUREL', 'JP LAUREL', 'J.P.', 'LAUREL'],
        ];

        // Build filter list for queries
        $filterBarangays = null;
        if ($barangay) {
            if (isset($barangayAliases[$barangay])) {
                $filterBarangays = $barangayAliases[$barangay];
            } else {
                // If not in alias map, just use the selected value
                $filterBarangays = [$barangay];
            }
        }

        // ================================
        // 3) TOTAL ASSISTANCE AMOUNT
        // ================================
        $totalAssistanceAmount = AcknowledgementReceipt::when(
            $filterBarangays,
            function ($q) use ($filterBarangays) {
                $q->whereIn('barangay', $filterBarangays);
            }
        )
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->sum('amount');

        // ================================
        // 4) TOP BARANGAYS
        // ================================
=======
        $lastUpdated = DB::table('ai_updates')->value('updated_at');

        $totalAssistanceAmount = (float) AcknowledgementReceipt::sum('amount');

        $totalBeneficiaries = AcknowledgementReceipt::distinct('client_verification_id')
            ->count('client_verification_id');

>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        $topBarangays = AcknowledgementReceipt::select(
            'barangay',
            DB::raw('COUNT(*) as total_assistances'),
            DB::raw('SUM(amount) as total_amount')
        )
<<<<<<< HEAD
            ->when($filterBarangays, function ($q) use ($filterBarangays) {
                $q->whereIn('barangay', $filterBarangays);
            })
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            ->groupBy('barangay')
            ->orderByDesc('total_assistances')
            ->limit(5)
            ->get();

<<<<<<< HEAD
        // ================================
        // 5) ASSISTANCE TYPE DATA
        // ================================
        $assistanceTypeData = ClientAssistanceLog::select(
            'client_assistance_logs.type',
            DB::raw('COUNT(*) as total')
        )
            ->leftJoin(
                'acknowledgement_receipts',
                'client_assistance_logs.client_id',
                '=',
                'acknowledgement_receipts.client_id'
            )
            ->when($filterBarangays, function ($q) use ($filterBarangays) {
                $q->whereIn('acknowledgement_receipts.barangay', $filterBarangays);
            })
            ->when($month, fn($q) => $q->whereMonth('client_assistance_logs.created_at', $month))
            ->when($year, fn($q) => $q->whereYear('client_assistance_logs.created_at', $year))
            ->groupBy('client_assistance_logs.type')
            ->get();

        // ================================
        // 6) MONTHLY TREND
        // ================================
        $monthlyTrend = ClientAssistanceLog::select(
            DB::raw("DATE_FORMAT(client_assistance_logs.created_at, '%b %Y') as month"),
            DB::raw('COUNT(*) as total'),
            DB::raw('MIN(client_assistance_logs.created_at) as min_created')
        )
            ->leftJoin(
                'acknowledgement_receipts',
                'client_assistance_logs.client_id',
                '=',
                'acknowledgement_receipts.client_id'
            )
            ->when($filterBarangays, function ($q) use ($filterBarangays) {
                $q->whereIn('acknowledgement_receipts.barangay', $filterBarangays);
            })
            ->when($month, fn($q) => $q->whereMonth('client_assistance_logs.created_at', $month))
            ->when($year, fn($q) => $q->whereYear('client_assistance_logs.created_at', $year))
            ->groupBy('month')
            ->orderBy('min_created')
            ->get();

        // ================================
        // 7) LAST UPDATED
        // ================================
        $lastUpdated = DB::table('ai_updates')->value('updated_at');

        // ================================
        // 8) TOTAL BENEFICIARIES
        // ================================
        $totalBeneficiaries = AcknowledgementReceipt::when(
            $filterBarangays,
            function ($q) use ($filterBarangays) {
                $q->whereIn('barangay', $filterBarangays);
            }
        )
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->distinct('client_verification_id')
            ->count('client_verification_id');

        // ================================
        // 9) BARANGAY DATA (for charts)
        // ================================
=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        $barangayData = AcknowledgementReceipt::select(
            'barangay',
            DB::raw('COUNT(*) as total_assistances'),
            DB::raw('SUM(amount) as total_amount')
        )
<<<<<<< HEAD
            ->when($filterBarangays, function ($q) use ($filterBarangays) {
                $q->whereIn('barangay', $filterBarangays);
            })
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->groupBy('barangay')
=======
            ->groupBy('barangay')
            ->orderByDesc('total_assistances')
            ->get();

        $assistanceTypeData = ClientAssistanceLog::select(
            'type',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $monthlyTrend = ClientAssistanceLog::select(
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
            DB::raw('COUNT(*) as total'),
            DB::raw('MIN(created_at) as min_created')
        )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('min_created')
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            ->get();

        $topBarangayName = $topBarangays->first()->barangay ?? '—';
        $topBarangayCount = $topBarangays->first()->total_assistances ?? 0;

        return view('admin.reports', compact(
            'totalAssistanceAmount',
            'totalBeneficiaries',
            'topBarangays',
            'barangayData',
<<<<<<< HEAD
            'barangayList',
=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            'assistanceTypeData',
            'monthlyTrend',
            'topBarangayName',
            'topBarangayCount',
            'lastUpdated'
        ));
    }

<<<<<<< HEAD

=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
    public function exportCsv()
    {
        $date = now()->format('Y-m-d');
        $fileName = "CSWDO_Report_{$date}.csv";

        // Fetch data (same logic)
        $barangayData = AcknowledgementReceipt::select(
            'barangay',
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as total_assistances')
        )
            ->groupBy('barangay')
            ->orderByDesc('total_amount')
            ->get();

        $assistanceTypeData = ClientAssistanceLog::select(
            'type',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('type')
            ->get();

        $monthlyTrend = ClientAssistanceLog::select(
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
            DB::raw("COUNT(*) as total")
        )
            ->groupByRaw("DATE_FORMAT(created_at, '%b %Y')")
            ->orderByRaw("MIN(created_at)")
            ->get();

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0"
        ];

        // Add BOM to fix Excel encoding issues
        $callback = function () use ($barangayData, $assistanceTypeData, $monthlyTrend) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM (fixes Excel encoding)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, ['Section', 'Category', 'Label', 'Value']);

            // Barangay Summary
            foreach ($barangayData as $item) {
                fputcsv($file, [
                    'Barangay Summary',
                    'Barangay',
                    $item->barangay,
                    '₱' . number_format($item->total_amount, 2)
                ]);
            }

            // Assistance Types
            foreach ($assistanceTypeData as $type) {
                fputcsv($file, [
                    'Assistance Type',
                    'Type',
                    $type->type,
                    $type->total
                ]);
            }

            // Monthly Trend
            foreach ($monthlyTrend as $month) {
                fputcsv($file, [
                    'Monthly Trend',
                    'Month',
                    $month->month,
                    $month->total
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function clusterAnalysis()
    {
        // READ the latest JSON file created by Python
        $jsonPath = public_path('python/cluster_results.json');

        if (!file_exists($jsonPath)) {
            return response()->json([
                'error' => 'cluster_results.json not found'
            ], 404);
        }

        // Decode JSON
        $kmeansData = json_decode(file_get_contents($jsonPath), true);

        return response()->json($kmeansData);
    }

    public function exportCluster()
    {
        $filePath = public_path('python/cluster_results.json');

        if (!file_exists($filePath)) {
            return back()->with('error', 'No cluster results found. Please run clustering first.');
        }

        $jsonData = json_decode(file_get_contents($filePath), true);

        $filename = 'CSWDO_Cluster_Report_' . date('Y-m-d') . '.csv';
        $csvPath = storage_path('app/public/' . $filename);

        $fp = fopen($csvPath, 'w');

        // UTF-8 BOM for Excel
        fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($fp, ['Barangay', 'Total Assistances', 'Total Amount', 'Cluster Label']);

        foreach ($jsonData as $row) {

            // FIXED: Peso sign encoding correct for Excel
            $formattedAmount = isset($row['total_amount'])
                ? mb_convert_encoding('₱' . number_format($row['total_amount'], 2), 'UTF-8', 'UTF-8')
                : '';

            fputcsv($fp, [
                $row['barangay'] ?? '',
                $row['total_assistances'] ?? '',
                $formattedAmount,
                $row['cluster_label'] ?? '',
            ]);
        }

        fclose($fp);

        return response()->download($csvPath)->deleteFileAfterSend(true);
    }



    public function exportClassificationResults()
    {
        $filePath = public_path('python/randomforest_results.json');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'No classification results found. Please run the Random Forest analysis first.');
        }

        $data = json_decode(file_get_contents($filePath), true);
        $filename = 'randomforest_results_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Client ID', 'Barangay', 'Total Assistances', 'Total Amount', 'Predicted Urgency', 'Is Anomaly'];

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data['rows'] as $row) {
                fputcsv($file, [
                    $row['client_id'],
                    $row['barangay'],
                    $row['total_assistances'],
                    $row['total_amount'],
                    $row['predicted_urgency'],
                    $row['is_anomaly'] ? 'Yes' : 'No',
                ]);
            }


            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
