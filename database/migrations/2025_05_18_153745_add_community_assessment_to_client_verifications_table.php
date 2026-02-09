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
            // $table->json('community_assessment')->nullable()->after('client_assessment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_verifications', function (Blueprint $table) {
            //$table->dropColumn('community_assessment');
        });
    }
};
