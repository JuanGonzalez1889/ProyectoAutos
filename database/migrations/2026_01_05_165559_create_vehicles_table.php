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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->decimal('price', 12, 2);
            $table->decimal('price_original', 12, 2)->nullable();
            $table->text('description');
            $table->string('fuel_type')->nullable(); // Gasolina, Diesel, Eléctrico, Híbrido
            $table->string('transmission')->nullable(); // Manual, Automático
            $table->integer('kilometers')->nullable();
            $table->string('color')->nullable();
            $table->string('plate')->nullable();
            $table->json('features')->nullable(); // Características: aire, GPS, etc
            $table->json('images')->nullable(); // Array de rutas de imágenes
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('status')->default('draft'); // draft, published, sold
            $table->boolean('featured')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('agencia_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
