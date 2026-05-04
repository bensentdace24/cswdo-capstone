<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcknowledgementReceipt extends Model
{
    use HasFactory;

    protected $table = 'acknowledgement_receipts';

    protected $fillable = [
        'client_id',
        'client_verification_id',
        'program_id',
        'recipient_name',
        'barangay',
        'amount',
        'amount_words',
        'type',
        'day_received',
        'month_received',
        'year_received',
        'received_date',
        'photo',
        'is_imported',
        'created_at',
        'updated_at',
    ];

    // Relationship to Client (if used)
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    // Relationship to ClientVerification
    public function clientVerification()
    {
        return $this->belongsTo(\App\Models\ClientVerification::class, 'client_verification_id');
    }

    // ✅ Relationship to AssistanceProgram (THIS FIXES THE ERROR)
    public function program()
    {
        return $this->belongsTo(\App\Models\AssistanceProgram::class, 'program_id');
    }
}
