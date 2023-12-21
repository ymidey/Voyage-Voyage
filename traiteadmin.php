<?php
include("header.php");

if ($_GET["delete"] && $_SESSION['admin'] == 1) {
    $idUser = $_GET['delete'];

    // Supprimer le billet avec l'ID spécifié
    $requete = "DELETE utilisateurs, commentaires FROM utilisateurs
            LEFT JOIN commentaires ON commentaires.id_user = utilisateurs.id
            WHERE utilisateurs.id = :id";
    $stmt = $db->prepare($requete);
    $stmt->execute(['id' => $idUser]);

    header("Location: panneladmin.php");
    exit;
}
