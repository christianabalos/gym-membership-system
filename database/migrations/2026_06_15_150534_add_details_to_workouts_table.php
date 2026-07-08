<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->foreignId('trainer_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $table->string('workout_type')->nullable()->after('trainer_id');
            $table->time('workout_time')->nullable()->after('workout_date');
            $table->string('status')->default('scheduled')->after('workout_time');
        });
    }

    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('trainer_id');
            $table->dropColumn(['workout_type', 'workout_time', 'status']);
        });
    }
};