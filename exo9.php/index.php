<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: registrer.php");
    exit();
}
?>

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

$etudiants = $pdo->query("SELECT * FROM etudiants")->fetchAll();

$classes = $pdo->query("SELECT * FROM classes")->fetchAll();

$profs = $pdo->query("
    SELECT professeurs.*, matiere.lib AS matiere, classes.libelle AS classe
    FROM professeurs
    JOIN matiere ON professeurs.id_matiere = matiere.id
    JOIN classes ON professeurs.id_classe = classes.id
")->fetchAll();
?>

<h2>Liste des étudiants</h2>
<ul>
<?php foreach ($etudiants as $etu): ?>
    <li><?= $etu['prenom'] . ' ' . $etu['nom'] ?> 
        <a href="Views/modif_etudiant.php?id=<?= $etu['id'] ?>">Modifier</a>
        <a href="Views/supprimer_etudiant.php?id=<?= $etu['id'] ?>">Supprimer</a>
    </li>
<?php endforeach; ?>
</ul>

<h2>Liste des classes</h2>
<ul>
<?php foreach ($classes as $classe): ?>
    <li><?= $classe['libelle'] ?></li>
<?php endforeach; ?>
</ul>

<h2>Liste des professeurs avec leur matière et classe (Bonus)</h2>
<ul>
<?php foreach ($profs as $prof): ?>
    <li><?= $prof['prenom'].' '.$prof['nom'].' - '.$prof['matiere'].' - Classe : '.$prof['classe'] ?></li>
<?php endforeach; ?>
</ul>

<h2>Ajouter une matière</h2>
<form action="Views/nouvelle_matiere.php" method="POST">
    <input type="text" name="libelle" placeholder="Libellé">
    <button type="submit">Valider</button>
</form>

<h2>Ajouter un étudiant</h2>
<form action="Views/nouvelle_etudiant.php" method="POST">
    <input type="text" name="prenom" placeholder="Prénom">
    <input type="text" name="nom" placeholder="Nom">
    <select name="classe_id">
        <?php foreach($classes as $classe): ?>
            <option value="<?= $classe['id'] ?>"><?= $classe['libelle'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Valider</button>
</form>

