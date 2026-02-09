<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientAssistanceLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\AssistanceLog;

class ClientAssistanceLogsController extends Controller
{
    public function add($client_id)
    {
        $client = Client::findOrFail($client_id);
        return view('staff.client_assistance_logs.add', compact('client'));
    }

    public function insert($client_id, Request $request)
    {
        $request->validate([
            'assisted_at' => 'required|date',
            'type' => 'nullable|string|max:255',
        ]);

        ClientAssistanceLog::create([
            'client_id' => $client_id,
            'assisted_at' => $request->assisted_at,
            'type' => $request->type,
        ]);

        return redirect('staff/client/list')->with('success', 'Assistance log recorded.');
    }
}
