<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('last_name');
            $table->string('marital_status')->nullable()->after('gender');
            $table->string('address')->nullable()->after('marital_status');
            $table->string('mobile_number')->nullable()->after('address');
            $table->string('qualification')->nullable()->after('mobile_number');
            $table->string('work_experience')->nullable()->after('qualification');
            $table->string('profile_pic')->nullable()->after('work_experience');
            $table->date('date_of_birth')->nullable()->after('profile_pic');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'marital_status',
                'address',
                'mobile_number',
                'qualification',
                'work_experience',
                'profile_pic',
                'date_of_birth',
            ]);
        });
    }
};
