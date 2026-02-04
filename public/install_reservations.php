<?php
/**
 * Create reservation tables
 * Visit: https://www.produit2fou.com/install_reservations.php
 * DELETE THIS FILE AFTER USE!
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h2>Installation des tables de reservations</h2>";

try {
    // Create reservation_services (packs) table
    if (Schema::hasTable('reservation_services')) {
        echo "<p style='color: orange;'>Table 'reservation_services' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE reservation_services (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                prix DECIMAL(10,2) DEFAULT 0,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");
        echo "<p style='color: green;'>Table 'reservation_services' creee!</p>";
    }

    // Create reservation_service_items (products in packs) table
    if (Schema::hasTable('reservation_service_items')) {
        echo "<p style='color: orange;'>Table 'reservation_service_items' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE reservation_service_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                service_id INT NOT NULL,
                inventaire_id INT NOT NULL,
                quantite INT DEFAULT 1,
                FOREIGN KEY (service_id) REFERENCES reservation_services(id) ON DELETE CASCADE,
                FOREIGN KEY (inventaire_id) REFERENCES inventaire(id) ON DELETE CASCADE
            )
        ");
        echo "<p style='color: green;'>Table 'reservation_service_items' creee!</p>";
    }

    // Create reservations table
    if (Schema::hasTable('reservations')) {
        echo "<p style='color: orange;'>Table 'reservations' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE reservations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                date_reservation DATE NOT NULL,
                client_nom VARCHAR(255),
                client_telephone VARCHAR(50),
                ville VARCHAR(255),
                adresse TEXT,
                type_mur VARCHAR(255),
                prix DECIMAL(10,2) DEFAULT 0,
                description TEXT,
                acompte TINYINT(1) DEFAULT 0,
                service_id INT,
                statut ENUM('en_attente', 'confirme', 'termine', 'annule') DEFAULT 'en_attente',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (service_id) REFERENCES reservation_services(id) ON DELETE SET NULL
            )
        ");
        echo "<p style='color: green;'>Table 'reservations' creee!</p>";
    }

    // Create reservation_photos table
    if (Schema::hasTable('reservation_photos')) {
        echo "<p style='color: orange;'>Table 'reservation_photos' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE reservation_photos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                reservation_id INT NOT NULL,
                chemin_photo VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE
            )
        ");
        echo "<p style='color: green;'>Table 'reservation_photos' creee!</p>";
    }

    echo "<h3 style='color: green;'>Installation terminee!</h3>";
    echo "<p><strong>IMPORTANT:</strong> Supprimez ce fichier apres utilisation!</p>";
    echo "<p><a href='/planning'>Aller au planning</a></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
