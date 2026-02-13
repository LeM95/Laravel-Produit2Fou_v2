<?php
/**
 * Script pour vider le cache de configuration
 * SUPPRIMER CE FICHIER APRES UTILISATION
 */

echo "<h2>Diagnostic Stripe</h2>";

// 1. Supprimer manuellement les fichiers de cache
$cacheFiles = [
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes-v7.php',
    __DIR__ . '/../bootstrap/cache/services.php',
    __DIR__ . '/../bootstrap/cache/packages.php',
];

echo "<h3>1. Suppression des fichiers de cache:</h3>";
foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<p style='color: green;'>Supprime: " . basename($file) . "</p>";
        } else {
            echo "<p style='color: red;'>Impossible de supprimer: " . basename($file) . "</p>";
        }
    } else {
        echo "<p style='color: gray;'>N'existe pas: " . basename($file) . "</p>";
    }
}

// 2. Lire directement le fichier .env
echo "<h3>2. Lecture directe du fichier .env:</h3>";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);

    // Chercher STRIPE_KEY
    if (preg_match('/^STRIPE_KEY=(.*)$/m', $envContent, $matches)) {
        $key = trim($matches[1]);
        echo "<p style='color: green;'>STRIPE_KEY trouve dans .env: " . substr($key, 0, 25) . "...</p>";
    } else {
        echo "<p style='color: red;'>STRIPE_KEY NON TROUVE dans .env</p>";
    }

    // Chercher STRIPE_SECRET
    if (preg_match('/^STRIPE_SECRET=(.*)$/m', $envContent, $matches)) {
        $secret = trim($matches[1]);
        echo "<p style='color: green;'>STRIPE_SECRET trouve dans .env: " . substr($secret, 0, 25) . "...</p>";
    } else {
        echo "<p style='color: red;'>STRIPE_SECRET NON TROUVE dans .env</p>";
    }
} else {
    echo "<p style='color: red;'>Fichier .env non trouve!</p>";
}

// 3. Maintenant charger Laravel et tester
echo "<h3>3. Test via Laravel:</h3>";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $stripeKey = config('services.stripe.key');
    $stripeSecret = config('services.stripe.secret');

    if ($stripeKey) {
        echo "<p style='color: green;'>Laravel config STRIPE_KEY: " . substr($stripeKey, 0, 25) . "...</p>";
    } else {
        echo "<p style='color: red;'>Laravel config STRIPE_KEY: NON CONFIGURE</p>";
    }

    if ($stripeSecret) {
        echo "<p style='color: green;'>Laravel config STRIPE_SECRET: " . substr($stripeSecret, 0, 25) . "...</p>";
    } else {
        echo "<p style='color: red;'>Laravel config STRIPE_SECRET: NON CONFIGURE</p>";
    }

    // Test direct avec env()
    echo "<h3>4. Test direct env():</h3>";
    $envKey = env('STRIPE_KEY');
    $envSecret = env('STRIPE_SECRET');

    if ($envKey) {
        echo "<p style='color: green;'>env('STRIPE_KEY'): " . substr($envKey, 0, 25) . "...</p>";
    } else {
        echo "<p style='color: red;'>env('STRIPE_KEY'): NON CONFIGURE</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur Laravel: " . $e->getMessage() . "</p>";
}

// 5. Test Stripe API (utilise env() directement)
echo "<h3>5. Test connexion Stripe:</h3>";
try {
    // Utiliser env() directement car config() ne fonctionne pas
    $stripeSecret = env('STRIPE_SECRET');
    if ($stripeSecret) {
        \Stripe\Stripe::setApiKey($stripeSecret);
        $account = \Stripe\Account::retrieve();
        echo "<p style='color: green;'>Connexion Stripe OK - Account ID: " . $account->id . "</p>";
    } else {
        echo "<p style='color: red;'>Impossible de tester - cle secrete non configuree</p>";
    }
} catch (\Exception $e) {
    echo "<p style='color: red;'>Erreur Stripe: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>SUPPRIMEZ CE FICHIER APRES UTILISATION!</p>";
echo "<p><a href='/reserver'>Tester /reserver</a></p>";
