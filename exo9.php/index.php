<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations Ecole</title>
    <link rel="stylesheet" href="css/fichier.css"> 
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'Model/pdo.php'; 
echo "<ul>";
echo "<h1>PARTIE 1 : Informations de la base de données</h1>";

try {
    echo "<h2>Liste des Étudiants</h2>";
    $stmt = $dbPDO->query("SELECT id, nom, prenom FROM etudiants"); 
    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) .
                 " <a href='Views/modif_etudiant.php?id=" . $row["id"] . "'>Modifier</a>" .
                 " <a href='Views/supprimer_etudiant.php?id=" . $row["id"] . "'>Supprimer</a></li>"; // Lien de suppression ajouté
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
            echo "<li>Classe : " . htmlspecialchars($row["libelle"]) . "</li>";
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
            echo "<li>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</li>";
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
            echo "<li>Professeur : " . htmlspecialchars($row["prenom_prof"]) . " " . htmlspecialchars($row["nom_prof"]) .
                 " Matière : " . htmlspecialchars($row["matiere"]) .
                 " Classe : " . htmlspecialchars($row["classe"]) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun enseignement trouvé.</p>";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<h1>PARTIE 3 : Ajout Matière</h1>

<a href="Views/nouvelle_matiere.php">
    <button type="button">Ajouter une matière</button>
</a>

</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['libelle'])) {
    try {
        $stmt = $dbPDO->prepare("INSERT INTO matiere (lib) VALUES (:libelle)");
        $stmt->execute(['libelle' => $_POST['libelle']]);
        echo "<p>Matière ajoutée avec succès : " . htmlspecialchars($_POST['libelle']) . "</p>";
    } catch (PDOException $e) {
        echo "<p>Erreur d'insertion : " . $e->getMessage() . "</p>";
    }
}
?>

<h2>Ajout Élève</h2>

<a href="Views/nouvelle_etudiant.php">
    <button type="button">Ajouter un Élève</button>
</a>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom']) && !empty($_POST['prenom']) && isset($_POST['classe_id'])) {
    try {
        $stmt = $dbPDO->prepare("INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, :classe_id)");
        $stmt->execute([
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'classe_id' => $_POST['classe_id']
        ]);
        echo "<p>Élève ajouté avec succès : " . htmlspecialchars($_POST['nom']) . " " . htmlspecialchars($_POST['prenom']) . "</p>";
    } catch (PDOException $e) {
        echo "<p>Erreur d'insertion : " . $e->getMessage() . "</p>";
    }
}
?>


</form>

</body>
</html>