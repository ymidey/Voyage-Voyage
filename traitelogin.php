<?php
include("header.php");

$login = $_GET["login"];
$mdp = $_GET["password"];
$url = $_GET["urlPrecedente"];
// On Vérifie si l'URL précédente contient "http://localhost/Blog_YannickMidey/register.php"
if (strpos($url, "http://localhost/Blog_YannickMidey/register.php") !== false) {
    // Si elle le contient, on change la veleur de $url
    $url = "accueil.php";
}

$users = getLogin($login);

if (count($users) == 1) {
    $result = $users[0];

    if (password_verify($mdp, $result["mdp"])) {
        $_SESSION['login'] = $result["login"];
        $_SESSION['pseudo'] = $result["pseudo"];
        $_SESSION['id_user'] = $result["id"];
        $_SESSION["admin"] = $result["admin"];
        header("location: " . $url);
    } else {
        header('location: login.php?erreur');
    }
} else {
    header('location: login.php?erreur');
}
