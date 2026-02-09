<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientVerification extends Model
{
    use HasFactory;

    protected $casts = [
        'client_assessment' => 'array',
        'environment' => 'array',
        'disaster_type' => 'array',
        'household_type' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function isEligible()
    {
        // Example logic — adjust based on your real eligibility rules
        return $this->eligibility_status === 'Eligible'
            || $this->assessment_result === 'Passed'
            || $this->approved == 1;
    }
}
