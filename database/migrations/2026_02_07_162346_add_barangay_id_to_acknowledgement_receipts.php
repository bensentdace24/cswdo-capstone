<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('acknowledgement_receipts')) {
            if (!Schema::hasColumn('acknowledgement_receipts', 'barangay_id')) {
                Schema::table('acknowledgement_receipts', function (Blueprint $table) {
                    $table->unsignedBigInteger('barangay_id')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('acknowledgement_receipts')) {
            if (Schema::hasColumn('acknowledgement_receipts', 'barangay_id')) {
                Schema::table('acknowledgement_receipts', function (Blueprint $table) {
                    $table->dropColumn('barangay_id');
                });
            }
        }
    }
};
