<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClientAssistanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assisted_at',
        'type',
        'notes',
    ];

    protected $casts = [
        'assisted_at' => 'date:Y-m-d',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
