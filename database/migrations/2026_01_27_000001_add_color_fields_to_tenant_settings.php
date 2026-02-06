<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('home_description_color', 7)->nullable()->after('home_description');
            $table->string('nosotros_description_color', 7)->nullable()->after('nosotros_description');
            $table->string('agency_name_color', 7)->nullable()->after('template');
        });
    }

    public function down(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn('home_description_color');
            $table->dropColumn('nosotros_description_color');
            $table->dropColumn('agency_name_color');
        });
    }
};
