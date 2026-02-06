<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skip - FK may already exist from initial table creation
        // This migration is kept for consistency but the FK is handled during table creation
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'agencia_id')) {
                $table->dropForeign(['agencia_id']);
            }
        });
    }
};
