<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainer_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainer_availability_id')->nullable()->constrained('trainer_availabilities')->nullOnDelete();
            $table->string('day');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status')->default('pending'); // pending, approved, cancelled, completed
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['trainer_id', 'appointment_date', 'start_time', 'end_time'], 'trainer_appointment_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_appointments');
    }
};