<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('navbar_agency_name')->nullable()->after('agency_name_color');
            $table->string('navbar_agency_name_color', 7)->nullable()->after('navbar_agency_name');
        });
    }

    public function down(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn('navbar_agency_name');
            $table->dropColumn('navbar_agency_name_color');
        });
    }
};
