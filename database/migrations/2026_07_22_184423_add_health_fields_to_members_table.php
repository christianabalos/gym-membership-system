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
        Schema::table('members', function (Blueprint $table) {

            $table->text('health_declaration')->nullable()->after('gender');

            $table->boolean('no_health_issue')
                ->default(false)
                ->after('health_declaration');

            $table->string('emergency_name')
                ->nullable()
                ->after('no_health_issue');

            $table->string('emergency_relationship')
                ->nullable()
                ->after('emergency_name');

            $table->string('emergency_phone')
                ->nullable()
                ->after('emergency_relationship');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {

            $table->dropColumn([
                'health_declaration',
                'no_health_issue',
                'emergency_name',
                'emergency_relationship',
                'emergency_phone',
            ]);

        });
    }
};
