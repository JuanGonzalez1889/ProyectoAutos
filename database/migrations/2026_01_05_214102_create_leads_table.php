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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('status')->default('new'); // new, contacted, interested, negotiating, won, lost
            $table->string('source')->nullable(); // web, phone, social_media, referral, walk_in, other
            $table->text('notes')->nullable();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Colaborador asignado
            $table->foreignId('agencia_id')->constrained('agencias')->cascadeOnDelete();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('next_follow_up')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
