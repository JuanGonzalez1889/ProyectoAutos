<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skip - FKs may already exist from initial table creation
        // This migration is kept for consistency but the FKs are handled during table creation
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'agencia_id')) {
                $table->dropForeign(['agencia_id']);
            }
        });

        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'agencia_id')) {
                $table->dropForeign(['agencia_id']);
            }
        });
    }
};
