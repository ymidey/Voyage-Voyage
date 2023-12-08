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
        <a href="accueil.php"><img src="./cruise_ship_icon_126034.png" alt="Page d'accueil" title="Page d'accueil"></a>
        <?php if (!isset($_SESSION["id_user"])) { ?>
            <a href="login.php">Se connecter</a>
        <?php } else { ?>
            <a href="deconnexion.php">Se déconnecter</a>
        <?php } ?>
    </nav>