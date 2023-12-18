<?php
include("header.php");

$pseudo = $_GET["pseudo"];
$login = $_GET["email"];

$mdp = $_GET["password"];
$mdp2 = $_GET["password2"];

if ($mdp == $mdp2) {

    $checkTitreBilletExiste = "SELECT id FROM utilisateurs WHERE pseudo = :pseudo";
    $checkStmt = $db->prepare($checkTitreBilletExiste);
    $checkStmt->execute(['pseudo' => $pseudo]);

    if ($checkStmt->rowCount() > 0) {
        header("location: register.php?erreur=pseudoExiste");
    } else {
        $requeteRegister = "INSERT INTO utilisateurs VALUES(NULL, :login, :mdp, :pseudo, 0)";
        $prep = $db->prepare($requeteRegister);
        $prep->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $prep->bindValue(':login', $login, PDO::PARAM_STR);

        $hash = password_hash($_GET["password"], PASSWORD_DEFAULT);

        $prep->bindValue(':mdp', $hash, PDO::PARAM_STR);

        $prep->execute();

        header("location: login.php");
    }
} else {
    header("location: register.php?erreur=mdp");
}
