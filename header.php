<?php
// On fait appel à notre fichier connexion.php afin de se connecter à la bdd
include('connectdb.php');
header("Access-Control-Allow-Origin: *");
// On récupère la session
session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le blog de Yannick</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="nav-header">
        <a href="accueil.php">Page d'accueil</a>
        <a href="archive.php">Archives</a>
        <a href="accueil.php"><img src="./src/images/cruise_ship_icon_126034.png" alt="Page d'accueil" title="Page d'accueil"></a>
        <?php if (!isset($_SESSION["id_user"])) {
            echo "<a href='login.php'>Se connecter</a>";
            echo "<a href='register.php'>S'inscrire</a>";
        } else {
            echo "<a href='deconnexion.php'>Se déconnecter</a>";
        }
        if (isset($_SESSION["admin"]) && ($_SESSION["admin"] == "1")) {
            echo "<a href='panneladmin.php'>Pannel Admin</a>";
        } ?>
    </nav>