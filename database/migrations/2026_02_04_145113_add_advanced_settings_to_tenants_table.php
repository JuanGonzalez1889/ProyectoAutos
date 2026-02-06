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
        Schema::table('tenants', function (Blueprint $table) {
            // Horarios de atención (JSON)
            if (!Schema::hasColumn('tenants', 'business_hours')) {
                $table->json('business_hours')->nullable()->comment('Horarios de atención por día');
            }
            
            // Redes sociales (JSON)
            if (!Schema::hasColumn('tenants', 'social_media')) {
                $table->json('social_media')->nullable()->comment('URLs de redes sociales');
            }
            
            // Métodos de pago aceptados (JSON)
            if (!Schema::hasColumn('tenants', 'payment_methods')) {
                $table->json('payment_methods')->nullable()->comment('Métodos de pago que acepta');
            }
            
            // WhatsApp de contacto (phone ya existe)
            if (!Schema::hasColumn('tenants', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            
            // Comisiones
            if (!Schema::hasColumn('tenants', 'commission_percentage')) {
                $table->decimal('commission_percentage', 5, 2)->default(0)->comment('Porcentaje de comisión');
            }
            
            if (!Schema::hasColumn('tenants', 'commission_currency')) {
                $table->string('commission_currency', 3)->default('USD');
            }
            
            // Datos contables
            if (!Schema::hasColumn('tenants', 'business_registration')) {
                $table->string('business_registration')->nullable()->comment('Número de registro comercial');
            }
            
            if (!Schema::hasColumn('tenants', 'tax_id')) {
                $table->string('tax_id')->nullable()->comment('RUT/CUIT/NIF');
            }
            
            if (!Schema::hasColumn('tenants', 'business_type')) {
                $table->string('business_type')->nullable()->comment('Tipo de negocio');
            }
            
            // Banca
            if (!Schema::hasColumn('tenants', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }
            
            if (!Schema::hasColumn('tenants', 'bank_account')) {
                $table->string('bank_account')->nullable();
            }
            
            if (!Schema::hasColumn('tenants', 'bank_account_holder')) {
                $table->string('bank_account_holder')->nullable();
            }
            
            if (!Schema::hasColumn('tenants', 'bank_routing_number')) {
                $table->string('bank_routing_number')->nullable();
            }
            
            // Información de facturación
            if (!Schema::hasColumn('tenants', 'billing_address')) {
                $table->text('billing_address')->nullable();
            }
            
            if (!Schema::hasColumn('tenants', 'billing_notes')) {
                $table->text('billing_notes')->nullable();
            }
            
            // Preferencias operacionales
            if (!Schema::hasColumn('tenants', 'auto_approve_leads')) {
                $table->boolean('auto_approve_leads')->default(false);
            }
            
            if (!Schema::hasColumn('tenants', 'response_time_hours')) {
                $table->integer('response_time_hours')->default(24)->comment('Tiempo máximo de respuesta esperado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $columns = [
                'business_hours',
                'social_media',
                'payment_methods',
                'whatsapp',
                'commission_percentage',
                'commission_currency',
                'business_registration',
                'tax_id',
                'business_type',
                'bank_name',
                'bank_account',
                'bank_account_holder',
                'bank_routing_number',
                'billing_address',
                'billing_notes',
                'auto_approve_leads',
                'response_time_hours',
            ];
            
            $existingColumns = Schema::getColumnListing('tenants');
            $columnsToDelete = array_intersect($columns, $existingColumns);
            
            if (!empty($columnsToDelete)) {
                $table->dropColumn($columnsToDelete);
            }
        });
    }
};
