<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: registrer.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'Model/pdo.php';

$etudiants = $pdo->query("SELECT etudiants.*, classes.libelle AS classe FROM etudiants LEFT JOIN classes ON etudiants.classe_id = classes.id")->fetchAll();
$classes = $pdo->query("SELECT * FROM classes")->fetchAll();
$profs = $pdo->query("SELECT professeurs.*, matiere.lib AS matiere, classes.libelle AS classe FROM professeurs JOIN matiere ON professeurs.id_matiere = matiere.id JOIN classes ON professeurs.id_classe = classes.id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 p-10">
    <h2 class="text-2xl font-bold mb-4">Gestion des étudiants</h2>
    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">Prénom</th>
                <th class="px-6 py-3">Nom</th>
                <th class="px-6 py-3">Classe</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etu): ?>
                <tr class="bg-white border-b">
                    <td class="px-6 py-4"><?= htmlspecialchars($etu['prenom']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($etu['nom']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($etu['classe']) ?></td>
                    <td class="px-6 py-4">
                        <a href="edit_etudiant.php?id=<?= $etu['id'] ?>" class="text-blue-500">Modifier</a>
                        <a href="delete_etudiant.php?id=<?= $etu['id'] ?>" class="text-red-500 ml-2">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2 class="text-2xl font-bold mt-8 mb-4">Ajouter un étudiant</h2>
    <form action="add_etudiant.php" method="POST" class="bg-white p-6 shadow-md rounded-lg">
        <div class="mb-4">
            <label class="block text-gray-700">Prénom :</label>
            <input type="text" name="prenom" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Nom :</label>
            <input type="text" name="nom" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Classe :</label>
            <select name="classe_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <?php foreach($classes as $classe): ?>
                    <option value="<?= $classe['id'] ?>"><?= htmlspecialchars($classe['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Ajouter</button>
    </form>
</body>
</html>
