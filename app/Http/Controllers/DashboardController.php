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
            $month = request('month');

	    $clientCount = ClientAssistanceLog::when($month, function ($q) use ($month) {
                $q->whereMonth('assisted_at', date('m', strtotime($month)))
                    ->whereYear('assisted_at', date('Y', strtotime($month)));
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


            // ✅ Pass data to the dashboard view
            return view('admin.dashboard', compact(
                'clientCount',
                'medicalCount',
                'pharmacyCount',
                'totalAmount'
            ));
        }

        if (Auth::user()->user_type == 2) {
            $month = request('month');

            $clientCount = ClientAssistanceLog::when($month, function ($q) use ($month) {
                $q->whereMonth('assisted_at', date('m', strtotime($month)))
                    ->whereYear('assisted_at', date('Y', strtotime($month)));
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

            return view('staff.dashboard', compact(
                'clientCount',
                'medicalCount',
                'pharmacyCount',
                'totalAmount'
            ));
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
        $query = AcknowledgementReceipt::query();

        // 🗓 Filter range
        if ($range !== 'all') {
            $months = (int) $range; // e.g. 12
            $query->where('created_at', '>=', now()->subMonths($months)->startOfMonth());
        }

        // 📊 Aggregate per month from ACKNOWLEDGEMENT RECEIPTS (source of truth)
        $rows = $query->select(
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as label"),
                DB::raw("SUM(CASE WHEN type = 'Medical' THEN 1 ELSE 0 END) as medical_count"),
                DB::raw("SUM(CASE WHEN type = 'Pharmacy' THEN 1 ELSE 0 END) as pharmacy_count"),
                DB::raw("SUM(amount) as total_amount"),
                DB::raw("MIN(created_at) as min_created")
            )
            ->groupBy('label')
            ->orderBy('min_created')
            ->get();

        // Build arrays for Chart.js
        $labels = [];
        $medical = [];
        $pharmacy = [];
        $totalAmount = [];

        foreach ($rows as $row) {
            $labels[] = $row->label;
            $medical[] = (int) $row->medical_count;
            $pharmacy[] = (int) $row->pharmacy_count;
            $totalAmount[] = (float) $row->total_amount;
        }

        return response()->json([
            'labels' => $labels,
            'medical' => $medical,
            'pharmacy' => $pharmacy,
            'totalAmount' => $totalAmount,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
