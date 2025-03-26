<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un nouvel étudiant</title>
    <link rel="stylesheet" href="../css/Fichier.css">
</head>
<body>

<h2>Ajouter un nouvel étudiant</h2>

<form action="nouvelle_etudiant.php" method="post">
    <label>Nom :</label>
    <input name="nom" id="nom" type="text" required /><br><br>

    <label>Prénom :</label>
    <input name="prenom" id="prenom" type="text" required /><br><br>

    <label>Classe :</label>
    <select name="classe_id" id="classe_id" required>
        <?php
        require '../Model/pdo.php';
        $stmtClasses = $dbPDO->query("SELECT id, libelle FROM classes");
        while ($classe = $stmtClasses->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $classe['id'] . "'>" . htmlspecialchars($classe['libelle']) . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Valider</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom']) && !empty($_POST['prenom']) && isset($_POST['classe_id'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $classe_id = $_POST['classe_id'];

    try {
        $stmt = $dbPDO->prepare("INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, :classe_id)");
        $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'classe_id' => $classe_id]);

        echo "<p>Étudiant ajouté avec succès : " . htmlspecialchars($nom) . " " . htmlspecialchars($prenom) . "</p>";
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<p><a href="../index.php">Retour à l'accueil</a></p>

</body>
</html>