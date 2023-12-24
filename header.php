<?php
// On fait appel à notre fichier connexion.php afin de se connecter à la bdd
include('./inc/reqBDD.php');
header("Access-Control-Allow-Origin: *");
// On récupère la session
session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyage-Voyage | Le mini-blog de Yannick</title>
    <link rel="shortcut icon" href="./src/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="nav-header">
        <div class="nav-right">
            <a href="accueil.php"><img src="./src/images/cruise_ship_icon_126034.png" alt="Page d'accueil" title="Page d'accueil"></a>
        </div>
        <div class="nav-left">
            <a href="accueil.php">Page d'accueil</a>
            <a href="archive.php">Archives</a>
            <?php
            if (isset($_SESSION["admin"]) && ($_SESSION["admin"] == "1")) {
                echo "<a href='panneladmin.php'>Pannel Admin</a>";
            }
            if (!isset($_SESSION["id_user"])) {
                echo "<a href='login.php'>Se connecter</a>";
                echo "<a href='register.php'>S'inscrire</a>";
            } else {
                echo "<a href='deconnexion.php'>Se déconnecter</a>";
            }
            ?>
        </div>
    </nav>