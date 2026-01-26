<?php
/**
 * Clear Laravel caches
 * Visit: https://www.produit2fou.com/clear_cache.php
 * DELETE THIS FILE AFTER USE!
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>Clearing Laravel Caches...</h2>";

try {
    // Clear route cache
    Artisan::call('route:clear');
    echo "<p>✅ Route cache cleared</p>";

    // Clear config cache
    Artisan::call('config:clear');
    echo "<p>✅ Config cache cleared</p>";

    // Clear view cache
    Artisan::call('view:clear');
    echo "<p>✅ View cache cleared</p>";

    // Clear application cache
    Artisan::call('cache:clear');
    echo "<p>✅ Application cache cleared</p>";

    echo "<h3 style='color: green;'>All caches cleared! Try again now.</h3>";
    echo "<p><strong>IMPORTANT:</strong> Delete this file (clear_cache.php) after use for security!</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
