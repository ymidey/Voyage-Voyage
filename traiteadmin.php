<?php
include("header.php");

if ($_GET["delete"] && $_SESSION['admin'] == 1) {
    if ($_GET["requete"] == "deluser") {
        $idUser = $_GET['delete'];

        // Supprimer le billet avec l'ID spécifié
        $requete = "DELETE utilisateurs, commentaires FROM utilisateurs
            LEFT JOIN commentaires ON commentaires.id_user = utilisateurs.id
            WHERE utilisateurs.id = :id";
        $stmt = $db->prepare($requete);
        $stmt->execute(['id' => $idUser]);

        header("Location: panneladmin.php");
        exit;
    } elseif ($_GET["requete"] == "delcom") {
        $idCom = $_GET['delete'];

        // Supprimer le billet avec l'ID spécifié
        $requete = "DELETE FROM commentaires WHERE commentaires.id_commentaire = :id";
        $stmt = $db->prepare($requete);
        $stmt->execute(['id' => $idCom]);
        header("Location: panneladmin.php");
        exit;
    }
}
