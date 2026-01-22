<?php
/**
 * Script d'optimisation Laravel
 * Supprimez ce fichier apres utilisation !
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<html><head><title>Optimisation</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#f5f5f5;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:10px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:10px;margin:10px 0;}";
echo "h1{color:#333;}</style></head><body>";

echo "<h1>Optimisation du site</h1>";

try {
    // Clear all caches first
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "<div class='success'>Config cache cleared</div>";

    \Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "<div class='success'>Route cache cleared</div>";

    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "<div class='success'>View cache cleared</div>";

    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "<div class='success'>Application cache cleared</div>";

    // Now cache everything for production
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    echo "<div class='success'>Config cached for production</div>";

    \Illuminate\Support\Facades\Artisan::call('route:cache');
    echo "<div class='success'>Routes cached for production</div>";

    \Illuminate\Support\Facades\Artisan::call('view:cache');
    echo "<div class='success'>Views cached for production</div>";

    echo "<br><strong>Site optimise !</strong><br><br>";
    echo "<a href='/'>Aller a l'accueil</a>";

} catch (Exception $e) {
    echo "<div class='error'>Erreur: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
