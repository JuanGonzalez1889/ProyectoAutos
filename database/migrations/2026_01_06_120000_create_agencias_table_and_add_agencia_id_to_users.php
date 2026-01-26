<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla agencias si no existe
        if (!Schema::hasTable('agencias')) {
            Schema::create('agencias', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('ubicacion')->nullable();
                $table->string('telefono', 50)->nullable();
                $table->timestamps();
            });
        }

        // Asegurar tenant_id en agencias para multi-tenancy
        if (Schema::hasTable('agencias') && !Schema::hasColumn('agencias', 'tenant_id')) {
            Schema::table('agencias', function (Blueprint $table) {
                $table->string('tenant_id')->nullable()->after('id');
                $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                $table->index('tenant_id');
            });
        }

        // Agregar agencia_id a users si falta
        if (!Schema::hasColumn('users', 'agencia_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('agencia_id')->nullable()->after('google_id')->constrained('agencias')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'agencia_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['agencia_id']);
                $table->dropColumn('agencia_id');
            });
        }

        if (Schema::hasTable('agencias') && Schema::hasColumn('agencias', 'tenant_id')) {
            Schema::table('agencias', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropIndex(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
};
