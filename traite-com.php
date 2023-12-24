<?php

include("header.php");

if (isset($_GET['id_billet']) && isset($_SESSION['id_user'])) {

    $id_billet = ($_GET['id_billet']);

    if (isset($_GET["requete"]) == "insert" && isset($_GET['com'])) {
        $commentaire = ($_GET['com']);
        $commentaire = nl2br($commentaire);
        $datePubli = new DateTime('now', new DateTimeZone('Europe/Paris'));

        addComment($id_billet, $commentaire, $datePubli);
        header("Location: billet.php?id_billet=" . $id_billet);
    } elseif (isset($_GET["requete"]) == "delete" && isset($_GET["idcom"])) {
        $id_com = $_GET['idcom'];

        deleteComment($id_com);

        header("Location: billet.php?id_billet=" . $id_billet);
    } elseif ($_GET["requete"] == "update" && isset($_GET['id_commentaire'])) {
        $idComment = $_GET['id_commentaire'];
        $nouveauContenu = $_GET['nouveau_contenu'];
        $nouveauContenu = nl2br($nouveauContenu);
        updateComment($idComment, $nouveauContenu);
        header("Location: billet.php?id_billet=" . $id_billet);
    }
} else {
    header("Location: accueil.php");
}
