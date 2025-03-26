<?php
require '../Model/pdo.php';

if(isset($_GET['id'])) {
    $req = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $req->execute([$_GET['id']]);
    $etu = $req->fetch();
}

$classes = $pdo->query("SELECT * FROM classes")->fetchAll();

if(isset($_POST['prenom'], $_POST['nom'], $_POST['classe_id'])) {
    $req = $pdo->prepare("UPDATE etudiants SET prenom=?, nom=?, classe_id=? WHERE id=?");
    $req->execute([$_POST['prenom'], $_POST['nom'], $_POST['classe_id'], $_GET['id']]);
    header('Location: ../index.php');
}
?>

<form method="POST">
    <input type="text" name="prenom" value="<?= $etu['prenom'] ?>">
    <input type="text" name="nom" value="<?= $etu['nom'] ?>">

    <select name="classe_id">
        <?php foreach($classes as $classe): ?>
            <option value="<?= $classe['id'] ?>" <?= ($classe['id'] == $etu['classe_id']) ? 'selected' : '' ?>>
                <?= $classe['libelle'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Modifier</button>
</form>

<a href="../index.php">Retour</a>
