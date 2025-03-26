<?php
$host = "localhost";
$dbname = "junia.sql"; // Remplace par ton vrai nom de base
$username = "root"; // Remplace si tu as un autre utilisateur
$password = "root"; // Mets ton mot de passe MySQL s'il y en a un

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
