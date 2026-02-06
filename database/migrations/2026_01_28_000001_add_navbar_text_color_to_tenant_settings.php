<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('navbar_text_color')->nullable()->after('navbar_agency_name_color');
        });
    }
    public function down(): void
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn('navbar_text_color');
        });
    }
};
