<?php
include("header.php");

if ($_GET["delete"] && $_SESSION['admin'] == 1) {
    if ($_GET["requete"] == "deluser") {
        $idUser = $_GET['delete'];
        deleteUser($idUser);
        header("Location: panneladmin.php");
    } elseif ($_GET["requete"] == "delcom") {
        $idCom = $_GET['delete'];
        deleteComment($idCom);
        header("Location: panneladmin.php");
    }
} else {
    header("Location: accueil.php");
}
