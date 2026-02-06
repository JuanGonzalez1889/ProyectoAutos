<?php
// Script para diagnosticar problema con upload de imagen en landing editor

echo "=== DIAGNÓSTICO DE UPLOAD DE IMÁGENES ===\n\n";

// 1. Verificar directorios
echo "1. Verificando directorios:\n";
echo "   - storage/app/public: " . (is_dir('storage/app/public') ? 'SÍ' : 'NO') . "\n";
echo "   - storage/app/public/landing-images: " . (is_dir('storage/app/public/landing-images') ? 'SÍ' : 'NO') . "\n";
echo "   - public/storage: " . (is_link('public/storage') ? 'SÍ (symlink)' : (is_dir('public/storage') ? 'SÍ (dir)' : 'NO')) . "\n";

// 2. Verificar permisos
echo "\n2. Verificando permisos:\n";
echo "   - storage/app/public es escribible: " . (is_writable('storage/app/public') ? 'SÍ' : 'NO') . "\n";
echo "   - storage/app/public/landing-images es escribible: " . (is_writable('storage/app/public/landing-images') ? 'SÍ' : 'NO') . "\n";

// 3. Probar creación de archivo
echo "\n3. Prueba de creación de archivo:\n";
$test_file = 'storage/app/public/landing-images/test_' . time() . '.txt';
try {
    if (file_put_contents($test_file, 'test') !== false) {
        echo "   - Archivo creado: SÍ\n";
        if (file_exists($test_file)) {
            unlink($test_file);
            echo "   - Archivo eliminado: SÍ\n";
        }
    } else {
        echo "   - file_put_contents retornó false\n";
    }
} catch (\Throwable $e) {
    echo "   - Error: " . $e->getMessage() . "\n";
}

// 4. Listar archivos existentes
echo "\n4. Archivos en landing-images:\n";
$files = @scandir('storage/app/public/landing-images');
if ($files) {
    $count = count($files) - 2; // Restar . y ..
    echo "   - Total de archivos: " . $count . "\n";
    if ($count > 0) {
        echo "   - Primeros 5 archivos:\n";
        foreach (array_slice(array_diff($files, ['.', '..']), 0, 5) as $file) {
            echo "     • $file\n";
        }
    }
} else {
    echo "   - No se pudo leer el directorio\n";
}

echo "\n✅ Diagnóstico completado\n";
?>