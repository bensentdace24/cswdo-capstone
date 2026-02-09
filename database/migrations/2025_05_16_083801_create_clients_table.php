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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->text('address')->nullable();
            $table->boolean('is_ips')->default(false);     // checkbox yes/no
            $table->boolean('is_4ps')->default(false);     // checkbox yes/no
            $table->integer('age')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('educational_attainment')->nullable();
            $table->string('occupation')->nullable();
            $table->string('religion')->nullable();
            $table->string('sex')->nullable(); // Male/Female/Other
            $table->string('civil_status')->nullable(); // Single/Married/Widowed
            $table->date('birthdate')->nullable();
            $table->timestamps();
        });

        Schema::create('client_dependents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('dependent_name');
            $table->integer('age')->nullable();
            $table->string('status')->nullable(); // Sick, Alive, etc.
            $table->string('relationship')->nullable();
            $table->string('occupation')->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('client_dependents');
    }
};
