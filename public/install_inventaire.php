<?php
/**
 * Create inventory tables
 * Visit: https://www.produit2fou.com/install_inventaire.php
 * DELETE THIS FILE AFTER USE!
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h2>Installation des tables d'inventaire</h2>";

try {
    // Create inventaire_categories table
    if (Schema::hasTable('inventaire_categories')) {
        echo "<p style='color: orange;'>Table 'inventaire_categories' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE inventaire_categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        // Insert default categories
        DB::table('inventaire_categories')->insert([
            ['nom' => 'Supports TV'],
            ['nom' => 'LEDs'],
            ['nom' => 'Rails metalliques'],
            ['nom' => 'Cables'],
            ['nom' => 'Visserie'],
            ['nom' => 'Outils'],
            ['nom' => 'Autre']
        ]);

        echo "<p style='color: green;'>Table 'inventaire_categories' creee avec categories par defaut!</p>";
    }

    // Create inventaire table
    if (Schema::hasTable('inventaire')) {
        echo "<p style='color: orange;'>Table 'inventaire' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE inventaire (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                description TEXT,
                emplacement VARCHAR(255),
                prix_achat DECIMAL(10,2) DEFAULT 0,
                stock INT DEFAULT 0,
                stock_min INT DEFAULT 5,
                categorie_id INT,
                photo VARCHAR(255),
                fournisseur VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (categorie_id) REFERENCES inventaire_categories(id) ON DELETE SET NULL
            )
        ");
        echo "<p style='color: green;'>Table 'inventaire' creee!</p>";
    }

    // Create inventaire_mouvements table
    if (Schema::hasTable('inventaire_mouvements')) {
        echo "<p style='color: orange;'>Table 'inventaire_mouvements' existe deja</p>";
    } else {
        DB::statement("
            CREATE TABLE inventaire_mouvements (
                id INT AUTO_INCREMENT PRIMARY KEY,
                inventaire_id INT NOT NULL,
                type ENUM('entree', 'sortie') NOT NULL,
                quantite INT NOT NULL,
                note TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (inventaire_id) REFERENCES inventaire(id) ON DELETE CASCADE
            )
        ");
        echo "<p style='color: green;'>Table 'inventaire_mouvements' creee!</p>";
    }

    echo "<h3 style='color: green;'>Installation terminee!</h3>";
    echo "<p><strong>IMPORTANT:</strong> Supprimez ce fichier apres utilisation!</p>";
    echo "<p><a href='/30032006'>Retour au panel admin</a></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
