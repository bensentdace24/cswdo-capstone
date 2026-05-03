<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToClientRequirementsTable extends Migration
{
    public function up(): void
    {
        Schema::table('client_requirements', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('is_submitted');
        });
    }

    public function down(): void
    {
        Schema::table('client_requirements', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
}
