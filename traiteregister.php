<?php
include("header.php");

$pseudo = $_GET["pseudo"];
$login = $_GET["email"];

$mdp = $_GET["password"];
$mdp2 = $_GET["password2"];

if ($mdp == $mdp2) {

    $users = getUserWithSpecificPseudo($pseudo);

    if (count($users) > 0) {
        header("location: register.php?erreur=pseudoExiste");
    } else {

        addUser($pseudo, $login, $mdp);
        header("location: login.php");
    }
} else {
    header("location: register.php?erreur=mdp");
}
