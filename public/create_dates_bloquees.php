<?php
/**
 * Script pour creer la table dates_bloquees
 * A supprimer apres execution
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Verifier si la table existe deja
    if (Schema::hasTable('dates_bloquees')) {
        echo "<h1 style='color: blue;'>Table deja existante</h1>";
        echo "<p>La table 'dates_bloquees' existe deja.</p>";
    } else {
        // Creer la table
        DB::statement("
            CREATE TABLE dates_bloquees (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                date DATE NOT NULL,
                raison VARCHAR(255) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                UNIQUE KEY unique_date (date)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        echo "<h1 style='color: green;'>Succes !</h1>";
        echo "<p>La table 'dates_bloquees' a ete creee avec succes.</p>";
    }

    echo "<p><strong>IMPORTANT :</strong> Supprimez ce fichier maintenant pour des raisons de securite.</p>";
    echo "<p><a href='/30032006/reservations'>Aller au planning admin</a></p>";

} catch (Exception $e) {
    echo "<h1 style='color: red;'>Erreur</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
