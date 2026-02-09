<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\ClientAssistanceLog;

class Client extends Model
{
    use HasFactory;

    // ... (Your existing $fillable array here) ...

    protected $fillable = [
        'full_name',
        'address',
        'is_ips',
        'is_4ps',
        'age',
        'birthplace',
        'contact_number',
        'educational_attainment',
        'occupation',
        'religion',
        'sex',
        'civil_status',
        'birthdate',
        'note',
    ];

    // Append these accessors to the model's array form
    protected $appends = ['eligibility_status', 'days_until_eligible'];

    public function clientVerification()
    {
        return $this->hasOne(\App\Models\ClientVerification::class, 'client_id');
    }

    public function requirements()
    {
        return $this->hasMany(ClientRequirement::class, 'client_id');
    }

    /**
     * Relationship to assistance logs (Standardized name).
     * We order by the date so the latest one is first.
     */
    public function assistanceLogs() // Renamed to CamelCase for Laravel standard, adjust relationship call if needed.
    {
        return $this->hasMany(ClientAssistanceLog::class)->orderByDesc('assisted_at');
    }

    /**
     * Accessor to get the boolean eligibility status (Used by the view: @if ($value->eligibility_status)).
     * Returns true if eligible, false otherwise.
     */
    public function getEligibilityStatusAttribute(): bool
    {
        // Eligible if days_until_eligible is 0 or less.
        return $this->days_until_eligible <= 0;
    }

    /**
     * Accessor to calculate the days remaining until the next assistance is allowed (90 days cooldown).
     * This method is OPTIMIZED for eager loading (must load assistanceLogs relationship).
     * Returns the number of days left (0 if eligible).
     */
    public function getDaysUntilEligibleAttribute(): int
    {
        $cooldownDays = 91; // Standardized cooldown period

        // Use the relationship collection to avoid an extra query, assuming eager loading via ->with('assistanceLogs')
        $lastAssistance = $this->assistanceLogs->first();

        if (!$lastAssistance) {
            return 0; // No log exists, client is eligible.
        }

        // Calculate the next eligibility date (90 days after the last assistance)
        $lastDate = Carbon::parse($lastAssistance->assisted_at)->startOfDay();
        $nextEligibilityDate = $lastDate->copy()->addDays($cooldownDays); // Use copy to avoid modifying the original date

        // Calculate the difference in days between now and the future eligibility date.
        // The 'false' parameter ensures the result is signed (positive if in the future, negative/zero if in the past/now).
        $daysRemaining = Carbon::now()->diffInDays($nextEligibilityDate, false);

        // If daysRemaining is positive, return it. Otherwise, return 0 (meaning eligible).
        return max(0, $daysRemaining);
    }
}
