<?php
echo "<h1>Configuration PHP pour les uploads</h1>";
echo "<table border='1' cellpadding='10' style='font-family: sans-serif;'>";
echo "<tr><th>Parametre</th><th>Valeur</th><th>Description</th></tr>";

echo "<tr><td><strong>max_file_uploads</strong></td><td>" . ini_get('max_file_uploads') . "</td><td>Nombre max de fichiers par requete</td></tr>";
echo "<tr><td><strong>upload_max_filesize</strong></td><td>" . ini_get('upload_max_filesize') . "</td><td>Taille max par fichier</td></tr>";
echo "<tr><td><strong>post_max_size</strong></td><td>" . ini_get('post_max_size') . "</td><td>Taille max totale POST</td></tr>";
echo "<tr><td><strong>max_execution_time</strong></td><td>" . ini_get('max_execution_time') . " sec</td><td>Temps max d'execution</td></tr>";
echo "<tr><td><strong>max_input_time</strong></td><td>" . ini_get('max_input_time') . " sec</td><td>Temps max pour parser input</td></tr>";
echo "<tr><td><strong>memory_limit</strong></td><td>" . ini_get('memory_limit') . "</td><td>Limite memoire</td></tr>";

echo "</table>";

echo "<br><br>";
echo "<h2>Pour augmenter les limites, modifie php.ini :</h2>";
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
echo "max_file_uploads = 100\n";
echo "upload_max_filesize = 50M\n";
echo "post_max_size = 500M\n";
echo "max_execution_time = 300\n";
echo "max_input_time = 300\n";
echo "memory_limit = 256M";
echo "</pre>";

echo "<p><strong>Chemin php.ini :</strong> " . php_ini_loaded_file() . "</p>";
echo "<p>Apres modification, redemarre Apache dans XAMPP.</p>";
?>
