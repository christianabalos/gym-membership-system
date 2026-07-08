<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            if (!Schema::hasColumn('workouts', 'membership_id')) {
                $table->foreignId('membership_id')->nullable()->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('workouts', 'member_id')) {
                $table->foreignId('member_id')->nullable()->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('workouts', 'trainer_id')) {
                $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('workouts', 'workout_date')) {
                $table->date('workout_date')->nullable();
            }

            if (!Schema::hasColumn('workouts', 'day')) {
                $table->string('day')->nullable();
            }

            if (!Schema::hasColumn('workouts', 'title')) {
                $table->string('title')->nullable();
            }

            if (!Schema::hasColumn('workouts', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('workouts', 'status')) {
                $table->string('status')->default('scheduled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            //
        });
    }
};