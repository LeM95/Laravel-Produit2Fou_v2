<?php
/**
 * Script d'installation - Protection anti-spam
 * Ajoute la colonne ip_address à la table messages
 *
 * Accéder via: /install_antispam.php
 * SUPPRIMER CE FICHIER APRÈS L'EXÉCUTION
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h2>Installation Protection Anti-Spam</h2>";

try {
    // Check if column already exists
    $columns = DB::select("SHOW COLUMNS FROM messages LIKE 'ip_address'");

    if (empty($columns)) {
        // Add ip_address column
        DB::statement("ALTER TABLE messages ADD COLUMN ip_address VARCHAR(45) NULL AFTER message");
        echo "<p style='color: green;'>✅ Colonne 'ip_address' ajoutée à la table messages</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ La colonne 'ip_address' existe déjà</p>";
    }

    echo "<hr>";
    echo "<h3>Protection anti-spam activée :</h3>";
    echo "<ul>";
    echo "<li>✅ Champ honeypot (piège invisible pour bots)</li>";
    echo "<li>✅ Validation du temps (minimum 3 secondes)</li>";
    echo "<li>✅ Question mathématique (captcha simple)</li>";
    echo "<li>✅ Détection de patterns spam</li>";
    echo "<li>✅ Limite de 3 messages/heure par IP</li>";
    echo "</ul>";

    echo "<p style='color: red; font-weight: bold;'>⚠️ IMPORTANT: Supprimez ce fichier après l'installation!</p>";
    echo "<p><code>rm public/install_antispam.php</code></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur: " . $e->getMessage() . "</p>";
}
