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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->index();
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('action'); // 'view', 'create', 'update', 'delete', 'login', etc.
            $table->string('module'); // 'vehicles', 'leads', 'tasks', 'users', 'events', etc.
            $table->string('model_type')->nullable(); // 'App\Models\Vehicle', etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID del recurso afectado
            $table->text('description')->nullable(); // Descripción detallada
            $table->json('changes')->nullable(); // Cambios realizados (para updates)
            $table->json('metadata')->nullable(); // Info adicional (IP, user agent, etc.)
            $table->string('status')->default('success'); // 'success', 'failed'
            $table->timestamps();
            $table->index(['tenant_id', 'user_id', 'created_at']);
            $table->index(['module', 'action', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
