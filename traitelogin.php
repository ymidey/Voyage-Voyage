<?php
include("header.php");

$login = $_GET["login"];
$mdp = $_GET["password"];
$url = $_GET["urlPrecedente"];

$requeteLogin = "SELECT * FROM utilisateurs WHERE login= :login";
$prep = $db->prepare($requeteLogin);
$prep->bindValue(':login', $login, PDO::PARAM_STR);
$prep->execute();

if ($prep->rowCount() == 1) {
    $result = $prep->fetch(PDO::FETCH_ASSOC);
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
