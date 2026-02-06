<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->string('hero_title', 255)->nullable()->after('nosotros_description_color');
            $table->string('hero_title_color', 10)->nullable()->after('hero_title');
        });
    }

    public function down()
    {
        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_title', 'hero_title_color']);
        });
    }
};
