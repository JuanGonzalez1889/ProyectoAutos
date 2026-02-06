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
        Schema::table('domains', function (Blueprint $table) {
            // Add new columns for domain validation and configuration
            $table->boolean('is_active')->default(true)->after('type');
            $table->enum('registration_status', ['available', 'registered', 'pending'])->default('available')->after('is_active');
            $table->boolean('dns_configured')->default(false)->after('registration_status');
            $table->boolean('ssl_verified')->default(false)->after('dns_configured');
            $table->json('metadata')->nullable()->after('ssl_verified');
            
            // Add indexes for better query performance
            $table->index('registration_status');
            $table->index('dns_configured');
            $table->index('ssl_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropIndex(['registration_status']);
            $table->dropIndex(['dns_configured']);
            $table->dropIndex(['ssl_verified']);
            $table->dropColumn([
                'is_active',
                'registration_status',
                'dns_configured',
                'ssl_verified',
                'metadata',
            ]);
        });
    }
};
