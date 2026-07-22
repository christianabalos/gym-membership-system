<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('method', ['QR', 'Manual'])
                ->default('QR')
                ->after('attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('method');
        });
    }
};
