<?php
$servername = "localhost"; // Nom du serveur
$username = "root"; // Nom d'utilisateur de la base de données
$password = "root"; // Mot de passe de la base de données
$dbname = "junia.sql"; // Nom de la base de données

try {
    $pdo = new PDO('mysql:host=localhost;dbname=junia.sql;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>