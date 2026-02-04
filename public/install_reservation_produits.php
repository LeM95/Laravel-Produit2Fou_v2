<?php
/**
 * Script d'installation pour la table reservation_produits
 * Cette table permet de lier les réservations aux produits du magasin (coloris/plaques)
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h1>Installation de la table reservation_produits</h1>";

try {
    // Check if table already exists
    if (Schema::hasTable('reservation_produits')) {
        echo "<p style='color: orange;'>La table 'reservation_produits' existe déjà.</p>";
    } else {
        // Get column types from existing tables
        $reservationIdType = DB::select("SHOW COLUMNS FROM reservations WHERE Field = 'id'")[0]->Type;
        $produitIdType = DB::select("SHOW COLUMNS FROM produits WHERE Field = 'id'")[0]->Type;

        echo "<p>Type reservation.id: $reservationIdType</p>";
        echo "<p>Type produits.id: $produitIdType</p>";

        // Create the pivot table with matching types (int for reservations, bigint unsigned for produits)
        DB::statement("
            CREATE TABLE reservation_produits (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                reservation_id INT NOT NULL,
                produit_id BIGINT UNSIGNED NOT NULL,
                notes VARCHAR(500) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
                FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
                UNIQUE KEY unique_reservation_produit (reservation_id, produit_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "<p style='color: green;'>Table 'reservation_produits' créée avec succès!</p>";
    }

    echo "<hr>";
    echo "<p><strong>Installation terminée!</strong></p>";
    echo "<p><a href='/30032006/reservations'>Aller au planning</a></p>";
    echo "<p style='color: red; font-weight: bold;'>IMPORTANT: Supprimez ce fichier après l'installation!</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
