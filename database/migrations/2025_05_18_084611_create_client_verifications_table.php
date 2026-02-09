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
        Schema::create('client_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->text('problem_presented')->nullable();

            // Briefcase Assessment
            $table->json('client_assessment')->nullable(); // Store checkboxes as JSON
            $table->text('family_condition')->nullable();

            // Environment
            $table->json('community_assessment')->nullable(); // ✅ MATCHES CONTROLLER

            // Disaster
            $table->date('disaster_date')->nullable();
            $table->json('disaster_type')->nullable(); // fire/flood/other
            $table->json('household_type')->nullable(); // owned/rented/living with
            $table->string('damage_type')->nullable(); // partially/totally

            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_verifications');
    }
};
