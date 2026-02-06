<?php
echo "Test de carga de imagen:\n";
echo "- Directorio destino: " . realpath('storage/app/public/landing-images') . "\n";
echo "- ¿Existe directorio? " . (is_dir('storage/app/public/landing-images') ? 'SÍ' : 'NO') . "\n";
echo "- ¿Escribible? " . (is_writable('storage/app/public/landing-images') ? 'SÍ' : 'NO') . "\n";

// Verificar symlink
$symlink_path = 'public/storage';
if (is_link($symlink_path)) {
    echo "- Symlink público: SÍ (apunta a " . realpath($symlink_path) . ")\n";
} else {
    echo "- Symlink público: NO (falta)\n";
}

// Listar archivos en landing-images
echo "\nArchivos en storage/app/public/landing-images:\n";
$files = glob('storage/app/public/landing-images/*');
if (empty($files)) {
    echo "  (vacío)\n";
} else {
    foreach ($files as $file) {
        echo "  - " . basename($file) . "\n";
    }
}
?>
