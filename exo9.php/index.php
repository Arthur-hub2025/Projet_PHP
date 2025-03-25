<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations Étudiants et Classes</title>
    <link rel="stylesheet" href="css/fichier.css"> 
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'Model/pdo.php'; 

echo "<h1>Informations de la base de données</h1>";

try {
    echo "<h2>Liste des Étudiants</h2>";
    $stmt = $dbPDO->query("SELECT nom, prenom FROM etudiants");
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>".htmlspecialchars($row["prenom"])." ".htmlspecialchars($row["nom"])."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun étudiant trouvé.</p>";
    }

    echo "<h2>Liste des Classes</h2>";
    $stmt = $dbPDO->query("SELECT id, libelle FROM classes");
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>"." - Classe: ".htmlspecialchars($row["libelle"])."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucune classe trouvée.</p>";
    }

    echo "<h2>Liste des Professeurs</h2>";
    $stmt = $dbPDO->query("SELECT nom, prenom FROM professeurs");
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>".htmlspecialchars($row["prenom"])." ".htmlspecialchars($row["nom"])."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun professeur trouvé.</p>";
    }

    echo "<h2>Professeurs, Matières et Classes</h2>";
    $stmt = $dbPDO->query("
        SELECT p.nom AS nom_prof, p.prenom AS prenom_prof, m.lib AS matiere, c.libelle AS classe
        FROM professeurs p
        JOIN matiere m ON p.id_matiere = m.id
        JOIN classes c ON p.id_classe = c.id
    ");
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>Professeur : ".htmlspecialchars($row["prenom_prof"])." ".htmlspecialchars($row["nom_prof"]).
                 " Matière : ".htmlspecialchars($row["matiere"]).
                 " Classe : ".htmlspecialchars($row["classe"])."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun enseignement trouvé.</p>";
    }

} catch (PDOException $e) {
    echo "Erreur : ".$e->getMessage();
}
?>
