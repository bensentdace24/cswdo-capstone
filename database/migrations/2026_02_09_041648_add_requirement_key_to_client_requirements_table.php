<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('requirement_key');
            $table->boolean('is_submitted')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->unique(['client_id', 'requirement_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_requirements');
    }
};
