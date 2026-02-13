<?php
/**
 * Script pour rendre la colonne email nullable dans la table messages
 * A supprimer apres execution
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Modifier la colonne email pour la rendre nullable
    DB::statement('ALTER TABLE messages MODIFY email VARCHAR(255) NULL');

    echo "<h1 style='color: green;'>Succes !</h1>";
    echo "<p>La colonne 'email' est maintenant nullable.</p>";
    echo "<p><strong>IMPORTANT :</strong> Supprimez ce fichier maintenant pour des raisons de securite.</p>";
    echo "<p><a href='/'>Retour a l'accueil</a></p>";

} catch (Exception $e) {
    echo "<h1 style='color: red;'>Erreur</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
