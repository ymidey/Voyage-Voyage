<?php
include("header.php");

if (
    isset($_GET["requete"])
    &&
    $_SESSION['admin'] == 1
) {
    if (
        $_GET["requete"] == "insert" && isset($_GET['titreBillet']) &&
        isset($_GET['contenu'])
    ) {
        $titre = ($_GET['titreBillet']);

        $checkStmt = getBilletWithSpecificTitle($titre);
        if ($checkStmt) {
            header("location: add-billet.php?erreur=titreExiste");
        } else {
            $contenu = ($_GET['contenu']);
            $contenu = nl2br($contenu);
            $date_publi = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date_publi = $date_publi->format("Y-m-d");
            $id_user = $_SESSION['id_user'];

            addBillet($id_user, $titre, $contenu, $date_publi);
            header("Location: accueil.php?validation=insert");
        }
    } elseif ($_GET["requete"] == "delete" && isset($_GET['idBillet']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $id_billet = $_GET['idBillet'];
        deleteBillet($id_billet);
        header("Location: accueil.php?validation=delete");
    } elseif ($_GET["requete"] == "update" && isset($_GET['idBillet'])) {
        $id_billet = $_GET['idBillet'];
        $nouveauTitre = $_GET['titre'];
        $nouveauContenu = $_GET['contenu'];
        $nouveauContenu = nl2br($nouveauContenu);

        updateBillet($id_billet, $nouveauTitre, $nouveauContenu);

        header("Location: accueil.php");
    }
} else {
    header("Location: accueil.php");
}
