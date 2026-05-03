<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceProgram extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'name',
        'active',
        // add other columns here if you have more
    ];

    // (Optional) If you want the inverse relationship later:
    public function acknowledgementReceipts()
    {
        return $this->hasMany(\App\Models\AcknowledgementReceipt::class, 'program_id');
    }
}
