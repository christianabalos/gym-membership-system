<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
    $table->id();
    $table->foreignId('member_id')->constrained()->cascadeOnDelete();
    $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();
    $table->string('plan_name');
    $table->decimal('price', 8, 2);
    $table->date('start_date');
    $table->date('end_date');
    $table->string('status')->default('active');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};