<?php
/**
 * Add 'visible' column to produits table
 * Visit: https://www.produit2fou.com/install_visible.php
 * DELETE THIS FILE AFTER USE!
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h2>Installation de la colonne 'visible'</h2>";

try {
    // Check if column exists
    if (Schema::hasColumn('produits', 'visible')) {
        echo "<p style='color: orange;'>La colonne 'visible' existe deja!</p>";
    } else {
        // Add the column
        DB::statement("ALTER TABLE produits ADD COLUMN visible TINYINT(1) DEFAULT 1");
        echo "<p style='color: green;'>Colonne 'visible' ajoutee avec succes!</p>";
    }

    echo "<p><strong>IMPORTANT:</strong> Supprimez ce fichier apres utilisation!</p>";
    echo "<p><a href='/30032006'>Retour au panel admin</a></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
