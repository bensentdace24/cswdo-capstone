<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'requirement_key',
        'is_submitted',
        'notes',
    ];

    // 🔗 Relationship to Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
