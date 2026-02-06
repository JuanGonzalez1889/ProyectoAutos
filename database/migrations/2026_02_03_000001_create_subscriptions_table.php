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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id'); // Coincide con tenants.id que es varchar
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('stripe_id')->nullable();
            $table->string('stripe_status')->nullable();
            $table->string('stripe_price')->nullable();
            $table->string('mercadopago_id')->nullable();
            $table->string('mercadopago_status')->nullable();
            $table->string('plan'); // basic, premium, enterprise
            $table->string('payment_method'); // stripe, mercadopago
            $table->string('status')->default('pending'); // pending, active, canceled, expired
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
