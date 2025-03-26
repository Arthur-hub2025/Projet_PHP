<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une nouvelle matière</title>
    <link rel="stylesheet" href="../css/Fichier.css">
</head>
<body>

<h2>Ajouter une nouvelle matière</h2>

<form action="nouvelle_matiere.php" method="post">
   <label>Libellé (nom de la matière) :</label>
   <input name="libelle" id="libelle" type="text" required />

   <button type="submit">Valider</button>
</form>

<?php
require '../Model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['libelle'])) {
    $libelle = trim($_POST['libelle']);

    try {
        $stmt = $dbPDO->prepare("INSERT INTO matiere (lib) VALUES (:libelle)");
        $stmt->execute(['libelle' => $libelle]);

        echo "<p>Matière ajoutée avec succès : " . htmlspecialchars($libelle) . "</p>";
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<p><a href="../index.php">Retour à l'accueil</a></p>

</body>
</html>
