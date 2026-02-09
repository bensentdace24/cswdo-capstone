<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAssistanceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientAssistanceLogController extends Controller
{
    public function add($client_id)
    {
        $client = Client::findOrFail($client_id);
        return view('admin.client_assistance_logs.add', compact('client'));
    }

    public function insert($client_id, Request $request)
    {

        $request->validate([
            'type' => 'nullable|string|max:255',
        ]);

        ClientAssistanceLog::create([
            'client_id' => $client_id,
            'assisted_at' => Carbon::now(),
            'type' => $request->type,
        ]);

        return redirect('admin/client/list')->with('success', 'Assistance log recorded.');
    }
}
