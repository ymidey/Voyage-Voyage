<?php

include("header.php");

if (isset($_GET['id_billet']) && isset($_SESSION['id_user'])) {

    $id_billet = ($_GET['id_billet']);

    if (isset($_GET["requete"]) == "insert" && isset($_GET['com'])) {
        $commentaire = ($_GET['com']);
        $commentaire = nl2br($commentaire);
        $datePubli = new DateTime('now', new DateTimeZone('Europe/Paris'));

        $requete = "INSERT INTO commentaires (id_Billets, id_user, contenu, date_publication) VALUES (:id_billet, :id_user, :contenu, :date_publication)";
        $stmt = $db->prepare($requete);

        $stmt->execute([
            'id_user' => $_SESSION["id_user"],
            'id_billet' => $id_billet,
            'contenu' => $commentaire,
            'date_publication' => $datePubli->format("Y-m-d H-i-s")
        ]);
        header("Location: billet.php?id_billet=" . $id_billet);
        exit;
    } elseif (isset($_GET["requete"]) == "delete" && isset($_GET["idcom"])) {
        $idCom = $_GET['idcom'];

        // Supprimer le billet avec l'ID spécifié
        $requete = "DELETE FROM commentaires WHERE id_commentaire = :id";
        $stmt = $db->prepare($requete);
        $stmt->execute(['id' => $idCom]);

        header("Location: billet.php?id_billet=" . $id_billet);
        exit;
    }
} else {
    header("Location: accueil.php");
}
