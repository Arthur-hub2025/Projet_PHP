<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script></head>
<body>
    <h2>Connexion</h2>
    <form action="submit_registrer.php" method="POST">

        <label>Login :</label>
        <input type="text" name="login" required>
        <br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
        


    </form>
</body>
</html>