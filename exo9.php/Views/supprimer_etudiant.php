<?php
require '../Model/pdo.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $req = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $req->execute([$id]);
    $etu = $req->fetch();

    if($etu) {
        $del = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
        if($del->execute([$id])) {
            header('Location: ../index.php');
            exit;
        } else {
            echo "Erreur : suppression impossible.";
        }
    } else {
        echo "Erreur : Étudiant introuvable.";
    }
} else {
    echo "Erreur : ID non spécifié.";
}
?>
<a href="../index.php">Retour</a>
