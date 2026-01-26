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
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('stat1')->default('150+')->after('show_vehicles');
            $table->string('stat2')->default('98%')->after('stat1');
            $table->string('stat3')->default('24h')->after('stat2');
            $table->string('stat1_label')->default('AUTOS VENDIDOS')->after('stat3');
            $table->string('stat2_label')->default('SATISFACCIÓN')->after('stat1_label');
            $table->string('stat3_label')->default('ATENCIÓN')->after('stat2_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn(['stat1', 'stat2', 'stat3', 'stat1_label', 'stat2_label', 'stat3_label']);
        });
    }
};
