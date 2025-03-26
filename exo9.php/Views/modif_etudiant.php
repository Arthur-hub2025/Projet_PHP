<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="../css/Fichier.css">
</head>
<body>

<h2>Liste des étudiants</h2>

<?php
require '../Model/pdo.php';

try {
    $stmt = $dbPDO->query("SELECT id, nom, prenom FROM etudiants");

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row['prenom']) . " " . htmlspecialchars($row['nom']) . 
                 " <a href='nouvelle_etudiant.php?id=" . $row['id'] . "'><button>Modifier</button></a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun étudiant trouvé.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}
?>
<p><a href="../index.php">Retour à l'accueil</a></p>

</body>
</html>
