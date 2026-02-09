<?php

<<<<<<< HEAD

=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientAssistanceLog;
use App\Models\AcknowledgementReceipt;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
=======

class DashboardController extends \App\Http\Controllers\Controller
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 2) {
<<<<<<< HEAD
            $clientCount     = Client::count();
            $medicalCount    = ClientAssistanceLog::where('type', 'Medical')->count();
            $pharmacyCount   = ClientAssistanceLog::where('type', 'Pharmacy')->count();
            $totalAmount     = AcknowledgementReceipt::sum('amount');

=======

            // ✅ Counts from your real data
            $clientCount     = \App\Models\Client::count();
            $medicalCount    = \App\Models\ClientAssistanceLog::where('type', 'Medical')->count();
            $pharmacyCount   = \App\Models\ClientAssistanceLog::where('type', 'Pharmacy')->count();
            $totalAmount     = \App\Models\AcknowledgementReceipt::sum('amount');

            // ✅ Pass data to the dashboard view
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
            return view('staff.dashboard', compact(
                'clientCount',
                'medicalCount',
                'pharmacyCount',
                'totalAmount'
            ));
        }
<<<<<<< HEAD
    }
    // ... rest of your code


    // ADD THIS NEW FUNCTION BELOW
    public function getStaffCashPattern($range = '12')
    {
        try {
            $monthsToSubtract = ($range === 'all') ? 60 : 12; // 5 years or 1 year
            $startDate = Carbon::now()->subMonths($monthsToSubtract)->startOfMonth();

            $labels = [];
            $medicalData = [];
            $pharmacyData = [];
            $amountData = [];

            for ($i = 0; $i <= $monthsToSubtract; $i++) {
                $currentMonth = $startDate->copy()->addMonths($i);
                $monthLabel = $currentMonth->format('M Y');
                $labels[] = $monthLabel;

                // Count Medical logs for this month
                $medicalData[] = ClientAssistanceLog::where('type', 'Medical')
                    ->whereMonth('created_at', $currentMonth->month)
                    ->whereYear('created_at', $currentMonth->year)
                    ->count();

                // Count Pharmacy logs for this month
                $pharmacyData[] = ClientAssistanceLog::where('type', 'Pharmacy')
                    ->whereMonth('created_at', $currentMonth->month)
                    ->whereYear('created_at', $currentMonth->year)
                    ->count();

                // Sum total amount for this month
                $amountData[] = AcknowledgementReceipt::whereMonth('created_at', $currentMonth->month)
                    ->whereYear('created_at', $currentMonth->year)
                    ->sum('amount');
            }

            return response()->json([
                'labels' => $labels,
                'medical' => $medicalData,
                'pharmacy' => $pharmacyData,
                'totalAmount' => $amountData
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
=======

        // 🟨 STUDENT SIDE
        else if (Auth::user()->user_type == 3) {
            // keep as is if not used
            return view('student.dashboard', $data);
        }

        // 🟧 PARENT SIDE
        else if (Auth::user()->user_type == 4) {
            return view('parent.dashboard', $data);
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
        }
    }
}
