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
        Schema::table('client_assistance_logs', function (Blueprint $table) {
           // $table->datetime('assisted_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_assistance_logs', function (Blueprint $table) {
          //  $table->date('assisted_at')->change();
        });
    }
};
