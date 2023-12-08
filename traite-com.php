<?php

include("header.php");

if (isset($_GET['com']) && isset($_GET['id_billet']) && isset($_SESSION['id_user'])) {

    $commentaire = ($_GET['com']);
    $id_billet = ($_GET['id_billet']);
    $datePubli = new DateTime('now', new DateTimeZone('Europe/Paris'));


    if (empty($commentaire)) {
        echo "Le commentaire ne peut pas être vide.";
    } else {
        $requete = "INSERT INTO commentaires (id_Billets, id_user, contenu, date_publication) VALUES (:id_billet, :id_user, :contenu, :date_publication)";
        $stmt = $db->prepare($requete);

        $stmt->execute([
            'id_user' => $_SESSION["id_user"],
            'id_billet' => $id_billet,
            'contenu' => $commentaire,
            'date_publication' => $datePubli->format("Y-m-d H-i-s")
        ]);
        header("Location: billet.php?id=" . $id_billet);
        exit;
    }
} else {
    header("Location: accueil.php");
}
