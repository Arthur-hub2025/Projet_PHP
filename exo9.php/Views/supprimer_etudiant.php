<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un étudiant</title>
    <link rel="stylesheet" href="../css/Fichier.css">
</head>
<body>

<h2>Supprimer un étudiant</h2>

<?php
require '../Model/pdo.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_etudiant = $_GET['id'];

    try {
        $stmt = $dbPDO->prepare("SELECT nom, prenom FROM etudiants WHERE id = :id");
        $stmt->execute(['id' => $id_etudiant]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            ?>
            <p>Êtes-vous sûr de vouloir supprimer l'étudiant suivant ?</p>
            <p>Nom : <?php echo htmlspecialchars($etudiant['nom']); ?></p>
            <p>Prénom : <?php echo htmlspecialchars($etudiant['prenom']); ?></p>

            <form method="POST" action="supprimer_etudiant.php?id=<?php echo $id_etudiant; ?>">
                <button type="submit">Confirmer la suppression</button>
            </form>
            <?php
        } else {
            echo "<p>Étudiant non trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_etudiant = $_POST['id'];

    try {
        $stmt = $dbPDO->prepare("DELETE FROM etudiants WHERE id = :id");
        $stmt->execute(['id' => $id_etudiant]);
        var_dump($stmt->rowCount()); 
        echo "<p>Étudiant supprimé avec succès.</p>";
        echo "<p><a href='../index.php'>Retour à l'accueil</a></p>";
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>ID d'étudiant invalide.</p>";
}
?>
<p><a href="../index.php">Retour à l'accueil</a></p>
</body>
</html>