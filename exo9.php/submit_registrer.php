<?php
session_start();

$login = strtolower($_POST['login']);
$users = [
    "admin" => "admin123",
    "arthur" => "Paille",
    "antoine" => "de conto"
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (isset($users[$login]) && $users[$login] === $password) {
        $_SESSION['user'] = $login;
        header("Location: index.php");
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}
?>