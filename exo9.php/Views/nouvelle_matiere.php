<?php
require '../Model/pdo.php'; // appelle BDD

if(isset($_POST['libelle'])) {
    $libelle = htmlspecialchars($_POST['libelle']);

    if(!empty($libelle)) {
        $req = $pdo->prepare("INSERT INTO matiere (lib) VALUES (?)");
        
        if($req->execute([$libelle])){
            header('Location: ../index.php');
            exit;
        } else {
            echo "Erreur : Impossible d'ajouter la matière en BDD.";
        }
    } else {
        echo "Erreur : Veuillez entrer un libellé valide.";
    }
} else {
    echo "Erreur : Formulaire incomplet.";
}
?>
<a href="../index.php">Retour</a> //acceuil
