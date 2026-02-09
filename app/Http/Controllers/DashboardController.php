<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientAssistanceLog;
use App\Models\AcknowledgementReceipt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 1) {

            // ✅ Counts from your real data
<<<<<<< HEAD
            $month = request('month');

            $clientCount = Client::when($month, function ($q) use ($month) {
                $q->whereMonth('created_at', date('m', strtotime($month)))
                    ->whereYear('created_at', date('Y', strtotime($month)));
            })->count();

            $medicalCount = ClientAssistanceLog::when($month, function ($q) use ($month) {
                $q->whereMonth('assisted_at', date('m', strtotime($month)))
                    ->whereYear('assisted_at', date('Y', strtotime($month)));
            })->where('type', 'Medical')->count();

            $pharmacyCount = ClientAssistanceLog::when($month, function ($q) use ($month) {
                $q->whereMonth('assisted_at', date('m', strtotime($month)))
                    ->whereYear('assisted_at', date('Y', strtotime($month)));
            })->where('type', 'Pharmacy')->count();

            $totalAmount = AcknowledgementReceipt::when($month, function ($q) use ($month) {
                $q->whereMonth('created_at', date('m', strtotime($month)))
                    ->whereYear('created_at', date('Y', strtotime($month)));
            })->sum('amount');

=======
            $clientCount     = \App\Models\Client::count();
            $medicalCount    = \App\Models\ClientAssistanceLog::where('type', 'Medical')->count();
            $pharmacyCount   = \App\Models\ClientAssistanceLog::where('type', 'Pharmacy')->count();
            $totalAmount     = \App\Models\AcknowledgementReceipt::sum('amount');
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17

            // ✅ Pass data to the dashboard view
            return view('admin.dashboard', compact(
                'clientCount',
                'medicalCount',
                'pharmacyCount',
                'totalAmount'
            ));
        }

        if (Auth::user()->user_type == 2) {
            $clientCount = \App\Models\Client::count();
            return view('staff.dashboard', compact('clientCount'));
        }

        // 🟨 STUDENT SIDE
        else if (Auth::user()->user_type == 3) {
            // keep as is if not used
            return view('student.dashboard', $data);
        }

        // 🟧 PARENT SIDE
        else if (Auth::user()->user_type == 4) {
            return view('parent.dashboard', $data);
        }
    }

    public function cashPattern($range)
    {
        try {
            // 🔗 Match the records using client_id (the correct common field)
            $query = \App\Models\ClientAssistanceLog::select(
                DB::raw("DATE_FORMAT(client_assistance_logs.created_at, '%b %Y') as month"),
                DB::raw("SUM(CASE WHEN client_assistance_logs.type = 'Medical' THEN 1 ELSE 0 END) as medical"),
                DB::raw("SUM(CASE WHEN client_assistance_logs.type = 'Pharmacy' THEN 1 ELSE 0 END) as pharmacy"),
                DB::raw("COALESCE(SUM(acknowledgement_receipts.amount), 0) as totalAmount")
            )
                ->leftJoin('acknowledgement_receipts', 'client_assistance_logs.client_id', '=', 'acknowledgement_receipts.client_id');

            // 🗓 Filter for last 12 months if not "all"
            if ($range !== 'all') {
                $query->where('client_assistance_logs.created_at', '>=', now()->subMonths(11)->startOfMonth());
            }

            $data = $query
                ->groupBy('month')
                ->orderBy(DB::raw('MIN(client_assistance_logs.created_at)'))
                ->get();

            return response()->json([
                'labels' => $data->pluck('month'),
                'medical' => $data->pluck('medical'),
                'pharmacy' => $data->pluck('pharmacy'),
                'totalAmount' => $data->pluck('totalAmount'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
