<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcknowledgementReceipt extends Model
{
    use HasFactory;

    protected $table = 'acknowledgement_receipts'; // Replace with your actual table name

    protected $fillable = [
        'client_id',
        'client_verification_id',
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
    ];

    // ✅ Relationship to Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientVerification()
    {
        return $this->belongsTo(\App\Models\ClientVerification::class, 'client_verification_id');
    }
}
