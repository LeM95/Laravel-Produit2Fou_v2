<?php
/**
 * Script pour ajouter la colonne ordre aux produits
 * Supprimez ce fichier apres utilisation !
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<html><head><title>Installation Ordre</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#f5f5f5;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:10px;margin:10px 0;}";
echo ".info{background:#cce5ff;color:#004085;padding:15px;border-radius:10px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:10px;margin:10px 0;}";
echo "h1{color:#333;}</style></head><body>";

echo "<h1>Installation colonne Ordre</h1>";

try {
    $schema = \Illuminate\Support\Facades\Schema::class;

    // Verifier si la colonne existe deja
    if (\Illuminate\Support\Facades\Schema::hasColumn('produits', 'ordre')) {
        echo "<div class='info'>La colonne 'ordre' existe deja dans la table produits.</div>";
    } else {
        // Ajouter la colonne
        \Illuminate\Support\Facades\Schema::table('produits', function ($table) {
            $table->integer('ordre')->default(0)->after('prix');
        });
        echo "<div class='success'>Colonne 'ordre' ajoutee avec succes!</div>";
    }

    echo "<div class='info'>";
    echo "<strong>Important:</strong> Supprimez ce fichier apres utilisation!<br><br>";
    echo "<a href='/30032006'>Aller au panel admin</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='error'>Erreur: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
