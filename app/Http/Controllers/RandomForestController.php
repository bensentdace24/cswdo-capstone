<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RandomForestController extends Controller
{
    public function index()
{
    $filePath = public_path('python/randomforest_results.json');

    if (!file_exists($filePath)) {
        $results = null;
    } else {
        $raw = file_get_contents($filePath);
        $results = json_decode($raw, true);

        if ($results === null) {
            $results = null;
        }
    }

    $lastUpdated = DB::table('ai_updates')->value('updated_at');

    return view('admin.classification', compact('results', 'lastUpdated'));
}
    public function runAnalysis()
{
    // Use the SAME venv python that works for clustering
    $python = base_path('venv/bin/python'); 
    $scriptPath = public_path('python/random_forest_classifier.py');

    // Build safe command
    $cmd = escapeshellcmd($python) . ' ' . escapeshellarg($scriptPath) . ' 2>&1';

    // Run and capture output
    $output = shell_exec($cmd);

    // Log for debugging
    \Log::info("RandomForest CMD: $cmd");
    \Log::info("RandomForest OUTPUT: " . $output);

    // Update timestamp (optional, keep if you want)
    \DB::table('ai_updates')->updateOrInsert(
        ['id' => 2],
        ['updated_at' => now('Asia/Manila')]
    );

    return redirect()->route('admin.classification')
        ->with('success', 'Random Forest Analysis executed successfully.');
}
}
