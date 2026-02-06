<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ACTUALIZANDO URLs DE IMÁGENES ===\n\n";

$settings = App\Models\TenantSetting::all();

foreach ($settings as $setting) {
    $updated = false;
    
    // Convertir banner_url
    if ($setting->banner_url && str_contains($setting->banner_url, 'http')) {
        $oldUrl = $setting->banner_url;
        // Extraer solo la parte /storage/...
        if (preg_match('#/storage/(.+)$#', $setting->banner_url, $matches)) {
            $setting->banner_url = '/storage/' . $matches[1];
            $updated = true;
            echo "Banner URL actualizada: {$oldUrl} -> {$setting->banner_url}\n";
        }
    }
    
    // Convertir logo_url
    if ($setting->logo_url && str_contains($setting->logo_url, 'http')) {
        $oldUrl = $setting->logo_url;
        if (preg_match('#/storage/(.+)$#', $setting->logo_url, $matches)) {
            $setting->logo_url = '/storage/' . $matches[1];
            $updated = true;
            echo "Logo URL actualizada: {$oldUrl} -> {$setting->logo_url}\n";
        }
    }
    
    if ($updated) {
        $setting->save();
        echo "✅ Settings guardados para tenant {$setting->tenant_id}\n\n";
    }
}

echo "\n✅ Proceso completado\n";
