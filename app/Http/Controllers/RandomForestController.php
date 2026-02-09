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

        $results = file_exists($filePath)
            ? json_decode(file_get_contents($filePath), true)
            : null;

        $lastUpdated = DB::table('ai_updates')->value('updated_at');

        return view('admin.classification', compact('results', 'lastUpdated'));
    }


    public function runAnalysis()
    {
        $python = config('python.python_path');
        $scriptPath = public_path('python/random_forest_classifier.py');

        // Correct and safe execution for Windows
        $command = "\"{$python}\" \"{$scriptPath}\" > NUL 2>&1";

        shell_exec($command);

        // Save timestamp
        DB::table('ai_updates')->updateOrInsert(
            ['id' => 2], // <-- use separate ID from K-Means
            ['updated_at' => now('Asia/Manila')]
        );

        return redirect()->route('admin.classification')
            ->with('success', 'Random Forest Analysis executed successfully.');
    }
}
