<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('agencias', 'plan_id')) {
            Schema::table('agencias', function (Blueprint $table) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('telefono');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('agencias', 'plan_id')) {
            Schema::table('agencias', function (Blueprint $table) {
                $table->dropColumn('plan_id');
            });
        }
    }
};
