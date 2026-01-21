<?php
$paths = [
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes.php',
    __DIR__ . '/../bootstrap/cache/services.php',
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        unlink($path);
    }
}

// Clear compiled views
$viewPath = __DIR__ . '/../storage/framework/views';
if (is_dir($viewPath)) {
    $files = glob($viewPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) unlink($file);
    }
}

echo "✅ Cache cleared!";
?>