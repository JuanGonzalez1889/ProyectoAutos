<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('font_family', 100)->nullable()->after('hero_title_color');
        });
    }

    public function down()
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn(['font_family']);
        });
    }
};
