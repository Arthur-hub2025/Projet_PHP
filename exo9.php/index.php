<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Model/pdo.php';

echo "<h1>Informations de la base de données</h1>";

try {
    echo "<h2>Liste des Étudiants</h2>";
    $sql = "SELECT nom, prenom FROM etudiants";
    $stmt = $dbPDO->query($sql);

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun étudiant trouvé.</p>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des étudiants : " . $e->getMessage();
}

try {
    echo "<h2>Liste des Classes</h2>";
    $sql = "SELECT id, libelle FROM classes";
    $stmt = $dbPDO->query($sql);

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>ID: " . htmlspecialchars($row["id"]) . " - Classe: " . htmlspecialchars($row["libelle"]) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucune classe trouvée.</p>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des classes : " . $e->getMessage();
}

    try {

        echo "<h2>Liste des Professeurs</h2>";
        $sql = "SELECT nom, prenom FROM professeurs";
        $stmt = $dbPDO->query($sql);
    
        if ($stmt->rowCount() > 0) {
            echo "<ul>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun Professeurs trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des Professeurs : " . $e->getMessage();
    }

    try {
        echo "<h2>Professeurs, Matières et Classes</h2>";
    
        $sql = "SELECT 
                    p.nom AS nom_prof, 
                    p.prenom AS prenom_prof, 
                    m.lib AS matiere, 
                    c.libelle AS classe
                FROM professeurs p
                JOIN matiere m ON p.id_matiere = m.id
                JOIN classes c ON p.id_classe = c.id";
    
        $stmt = $dbPDO->query($sql);
    
        if ($stmt->rowCount() > 0) {
            echo "<ul>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>";
                echo "Professeur : " . htmlspecialchars($row["prenom_prof"]) . " " . htmlspecialchars($row["nom_prof"]);
                echo " – Matière : " . htmlspecialchars($row["matiere"]);
                echo " – Classe : " . htmlspecialchars($row["classe"]);
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun enseignement trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo " Erreur lors de la récupération des enseignements : " . $e->getMessage();
    }
    
?>
