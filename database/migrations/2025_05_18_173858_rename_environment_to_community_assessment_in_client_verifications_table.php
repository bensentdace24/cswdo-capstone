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
            // $table->renameColumn('environment', 'community_assessment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_verifications', function (Blueprint $table) {
            // $table->renameColumn('community_assessment', 'environment');
        });
    }
};
