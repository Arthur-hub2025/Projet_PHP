<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($_GET['id']) ? "Modifier un étudiant" : "Ajouter un nouvel étudiant"; ?></title>
    <link rel="stylesheet" href="../css/Fichier.css">
</head>
<body>

<h2><?php echo isset($_GET['id']) ? "Modifier un étudiant" : "Ajouter un nouvel étudiant"; ?></h2>

<?php
require '../Model/pdo.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$nom = "";
$prenom = "";
$classe_id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $dbPDO->prepare("SELECT nom, prenom, classe_id FROM etudiants WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant) {
            $nom = htmlspecialchars($etudiant['nom']);
            $prenom = htmlspecialchars($etudiant['prenom']);
            $classe_id = $etudiant['classe_id'];
        } else {
            echo "<p>Étudiant non trouvé.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom']) && !empty($_POST['prenom']) && isset($_POST['classe_id'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $classe_id = $_POST['classe_id'];

    try {
        if (isset($_GET['id'])) {
            $stmt = $dbPDO->prepare("UPDATE etudiants SET nom = :nom, prenom = :prenom, classe_id = :classe_id WHERE id = :id");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'classe_id' => $classe_id, 'id' => $id]);
            echo "<p>Modification réussie ! <a href='../index.php'>Retour à la liste</a></p>";
        } else {
            $stmt = $dbPDO->prepare("INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, :classe_id)");
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'classe_id' => $classe_id]);
            echo "<p>Étudiant ajouté avec succès : " . htmlspecialchars($nom) . " " . htmlspecialchars($prenom) . "</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<form action="<?php echo isset($_GET['id']) ? "nouvelle_etudiant.php?id=$id" : "nouvelle_etudiant.php"; ?>" method="post">
    <label>Nom :</label>
    <input name="nom" id="nom" type="text" value="<?= $nom ?>" required /><br><br>

    <label>Prénom :</label>
    <input name="prenom" id="prenom" type="text" value="<?= $prenom ?>" required /><br><br>

    <label>Classe :</label>
    <select name="classe_id" id="classe_id" required>
        <?php
        $stmtClasses = $dbPDO->query("SELECT id, libelle FROM classes");
        while ($classe = $stmtClasses->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($classe['id'] == $classe_id) ? "selected" : "";
            echo "<option value='" . $classe['id'] . "' " . $selected . ">" . htmlspecialchars($classe['libelle']) . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit"><?php echo isset($_GET['id']) ? "Mettre à jour" : "Ajouter"; ?></button>
</form>

<p><a href="../index.php">Retour à l'accueil</a></p>

</body>
</html>