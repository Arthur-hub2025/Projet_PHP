<?php
require '../Model/pdo.php';

if(isset($_POST['prenom'], $_POST['nom'], $_POST['classe_id'])) {
    
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $classe_id = intval($_POST['classe_id']);

    if(!empty($prenom) && !empty($nom) && $classe_id > 0) {
        $req = $pdo->prepare("INSERT INTO etudiants (prenom, nom, classe_id) VALUES (?, ?, ?)");
        
        if($req->execute([$prenom, $nom, $classe_id])){
            header('Location: ../index.php');
            exit;
        } else {
            echo "Erreur : L'insertion en base de données a échoué.";
        }
    } else {
        echo "Erreur : Remplissez correctement tous les champs !";
    }
} else {
    echo "Erreur : Formulaire incomplet.";
}
?>
<a href="../index.php">Retour</a>
