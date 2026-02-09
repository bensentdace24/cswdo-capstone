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
        Schema::table('client_verifications', function (Blueprint $table) {
            $table->string('living_with')->nullable()->after('household_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_verifications', function (Blueprint $table) {
            $table->dropColumn('living_with');
        });
    }
};
