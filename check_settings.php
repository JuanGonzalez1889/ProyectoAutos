<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tenant = App\Models\Tenant::where('id', 'a4bd018d-5978-4e30-a935-9718c6a18102')->first();

if (!$tenant) {
    echo "Tenant no encontrado\n";
    exit;
}

$settings = $tenant->settings;

if (!$settings) {
    echo "Settings no encontrados\n";
    exit;
}

echo "=== CONFIGURACIÓN DEL TENANT ===\n";
echo "Tenant: " . $tenant->name . "\n";
echo "Template: " . ($settings->template ?? 'NULL') . "\n";
echo "Banner URL: " . ($settings->banner_url ?? 'NULL') . "\n";
echo "Logo URL: " . ($settings->logo_url ?? 'NULL') . "\n";
echo "Primary color: " . ($settings->primary_color ?? 'NULL') . "\n";
echo "Secondary color: " . ($settings->secondary_color ?? 'NULL') . "\n";
