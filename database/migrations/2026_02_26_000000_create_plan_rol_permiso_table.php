<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_rol_permiso', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id'); // slug del plan (basico, profesional, etc.)
            $table->unsignedBigInteger('rol_id');
            $table->string('permiso'); // nombre del permiso o módulo
            $table->boolean('visible')->default(true);
            $table->timestamps();

            // Solo foreign key a roles
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_rol_permiso');
    }
};
